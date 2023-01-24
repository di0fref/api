<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\NotificationsUsers;
use App\Models\Project;
use App\Models\ProjectsUsers;
use App\Models\Task;
use App\Models\TaskChanges;
use App\Models\User;

use Illuminate\Support\Facades\Auth;
use function response;


class TaskController extends Controller
{
    function getChanges($id, \Illuminate\Http\Request $request)
    {
        $changes = TaskChanges::where("task_id", $id)->leftJoin("tasks", "tasks.id", "=", "task_changes.task_id")->leftJoin("users", "users.id", "=", "task_changes.user_id")
//            ->leftJoin("project", "project.id", "=", "task_changes.task_id")

            ->orderBy("task_changes.created_at", "desc")->selectRaw("
                task_changes.id as id,
                users.name as changed_by_name,
                task_changes.created_at,
                task_changes.field,
                task_changes.old,
                task_changes.new,
                task_changes.created_at,
                DATE_FORMAT(task_changes.created_at, '%Y-%m-%d') as day_changed,
                task_changes.type,
                users.image_url
                ")->get();

        return response()->json($changes, 200);
    }

    public function getOne($id)
    {
        return response()->json($this->getTask($id), 201);

    }

    function getTask($id)
    {
        $task = Task::where("tasks.id", $id)
            ->leftJoin("projects", "projects.id", "=", "tasks.project_id")
            ->leftJoin("projects_users", "projects_users.project_id", "=", "projects.id")
            ->leftJoin("users", "tasks.assigned_user_id", "=", "users.id")
            ->selectRaw("tasks.*,
                users.name as assigned_user_name,
                users.id as assigned_user_id,
                users.image_url,
                CASE WHEN projects.name = '' or  projects.name is null THEN 'No project' ELSE projects.name END as project,
                projects.color as project_color")->first();

        $task->link = "kale";

        return $task;
    }

    function getAll(\Illuminate\Http\Request $request)
    {
        $tasks = Task::leftJoin("projects", "projects.id", "=", "tasks.project_id")
            ->leftJoin("projects_users", "projects_users.project_id", "=", "projects.id")
            ->leftJoin("users", "tasks.assigned_user_id", "=", "users.id")
            ->whereIn("projects_users.status",["owner", "accepted"] )
            ->where("projects_users.user_id", Auth::id())
            ->selectRaw("tasks.*,
                tasks.name as title,
                users.name as assigned_user_name,
                users.id as assigned_user_id,
                users.image_url,
                CASE WHEN projects.name = '' or projects.name is null THEN 'No project' ELSE projects.name END as project,
                projects.color as project_color")->distinct()->get();

//        foreach ($tasks as $task) {
//            $task->link = "ömdvöm";
//        }

        return response()->json($tasks);
    }

    function create(\Illuminate\Http\Request $request)
    {
        $new_task = Task::create($request->all());

        return response()->json($this->getTask($new_task->id), 201);
    }

    function update($id, \Illuminate\Http\Request $request)
    {
        $d = $request->all();
        $task = Task::findOrFail($id);
        $task->update($d);

        /* Log changes */

        $changes = $request->get("changes");

        foreach ($changes as $change) {
            if (isset($change["field"])) {
                TaskChanges::create(array_merge($change, ["task_id" => $task->id]));
            }
        }

        $notifications = $request->get("notifications");

        if (!empty($notifications)) {
            foreach ($request->get("notifications") as $notification) {

                $notification = (object)$notification;

                $new_notification = Notification::create(
                    [
                        "user_id" => $notification->user_id,
                        "action" => $notification->action,
                        "module_id" => $notification->module_id,
                        "module" => $notification->module,
                        "by_user_id" => $notification->by_user_id,
                    ]
                );

                $project_users = ProjectsUsers::where("project_id", $task->project_id)->get();

                foreach ($project_users as $project_user) {
                    NotificationsUsers::create([
                        "user_id" => $project_user->user_id,
                        "notification_id" => $new_notification->id
                    ]);
                }
            }
        }

        return response()->json($this->getTask($task->id), 201);
    }

    function delete($id)
    {
        Task::findOrFail($id)->delete();
        return response()->json(["id" => $id], 200);
    }
}
