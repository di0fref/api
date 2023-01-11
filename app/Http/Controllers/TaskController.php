<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use function response;


class TaskController extends Controller
{
    function getAll(\Illuminate\Http\Request $request)
    {
        $tasks = Task::whereBelongsTo(Auth::user())

            ->leftJoin("projects", "projects.id", "=", "tasks.project_id")
            ->leftJoin("projects_users", "projects_users.project_id", "=", "projects.id")
            ->leftJoin("users", "tasks.assigned_user_id", "=", "users.id")

            ->orWhere("projects_users.user_id", Auth::id())

            ->select(
                "tasks.*",
                "users.name as assigned_user_name",
                "users.id as assigned_user_id",
                "users.image_url",
                "projects.name as project",
                "projects.color as project_color")
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

        $task = Task::whereBelongsTo(Auth::user())
            ->where("tasks.id", $new_task->id)
            ->leftJoin("projects", "projects.id", "=", "tasks.project_id")
            ->select("tasks.*", "projects.name as project", "projects.color as project_color")->first();

        return response()->json($task, 201);
    }

    function update($id, \Illuminate\Http\Request $request)
    {
        $d = $request->all();
        $task = Task::findOrFail($id);
        $task->update($d);

//        $task = Task::whereBelongsTo(Auth::user())
//            ->where("tasks.id", $task->id)
//            ->leftJoin("projects", "projects.id", "=", "tasks.project_id")
//            ->leftJoin("users", "tasks.user_id", "=", "users.id")
//
//            ->select("users.image_url", "tasks.*","users.name as assigned_user_name", "projects.name as project", "projects.color as project_color")->first();
//

        $task = Task::whereBelongsTo(Auth::user())
            ->where("tasks.id", $task->id)
            ->leftJoin("projects", "projects.id", "=", "tasks.project_id")
            ->leftJoin("projects_users", "projects_users.project_id", "=", "projects.id")
            ->leftJoin("users", "tasks.assigned_user_id", "=", "users.id")

            ->orWhere("projects_users.user_id", Auth::id())

            ->select(
                "tasks.*",
                "users.name as assigned_user_name",
                "users.id as assigned_user_id",
                "users.image_url",
                "projects.name as project",
                "projects.color as project_color")
            ->first();



        return response()->json($task, 200);
    }

    function delete($id)
    {
        Task::findOrFail($id)->delete();
        return response()->json(["id" => $id], 200);
    }
}
