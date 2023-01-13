<?php

namespace App\Http\Controllers;

use App\Models\ProjectsUsers;
use App\Models\Task;
use App\Models\User;

use Illuminate\Support\Facades\Auth;
use function response;


class TaskController extends Controller
{

    function getTask($id)
    {
        $task = Task::where("tasks.id", $id)
            ->leftJoin("projects", "projects.id", "=", "tasks.project_id")
            ->leftJoin("projects_users", "projects_users.project_id", "=", "projects.id")
            ->leftJoin("users", "tasks.assigned_user_id", "=", "users.id")
            ->selectRaw(
                "tasks.*,
                users.name as assigned_user_name,
                users.id as assigned_user_id,
                users.image_url,
                CASE WHEN projects.name = '' or  projects.name is null THEN 'No project' ELSE projects.name END as project,
                projects.color as project_color")
            ->first();

        return $task;
    }

    function getAll(\Illuminate\Http\Request $request)
    {
        $tasks = Task::whereBelongsTo(Auth::user())
            ->leftJoin("projects", "projects.id", "=", "tasks.project_id")
            ->leftJoin("projects_users", "projects_users.project_id", "=", "projects.id")
            ->leftJoin("users", "tasks.assigned_user_id", "=", "users.id")
            ->orWhere("projects_users.user_id", Auth::id())
            ->selectRaw(
                "tasks.*,
                users.name as assigned_user_name,
                users.id as assigned_user_id,
                users.image_url,
                CASE WHEN projects.name = '' or  projects.name is null THEN 'No project' ELSE projects.name END as project,
                projects.color as project_color")
            ->distinct()->get();


        return response()->json(
            $tasks
        );
    }

    function create(\Illuminate\Http\Request $request)
    {
        $new_task = Task::create(
            $request->all()
        );

        return response()->json($this->getTask($new_task->id), 201);
    }

    function update($id, \Illuminate\Http\Request $request)
    {
        $d = $request->all();
        $task = Task::findOrFail($id);
        $task->update($d);


        return response()->json($this->getTask($task->id), 201);
    }

    function delete($id)
    {
        Task::findOrFail($id)->delete();
        return response()->json(["id" => $id], 200);
    }
}
