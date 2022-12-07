<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use function response;


class TaskController extends Controller
{
    function getAll(\Illuminate\Http\Request $request)
    {
        $task = Task::where("tasks.user_id", Auth::id())
            ->orderBy("due", "asc")
            ->orderBy("tasks.order", "asc")
            ->leftJoin("projects", "projects.id", "=", "tasks.project_id")
            ->select("tasks.*", "projects.name as project", "projects.color as project_color")->get();

        return response()->json(
            $task
        );

    }

    function create(\Illuminate\Http\Request $request)
    {
        $task = Task::create(
            [
                "user_id" => Auth::id(),
                "name" => $request->name,
                "text" => $request->text,
                "due" => $request->due ? $request->due : null,
                "prio" => $request->prio,
                "project_id" => $request->project_id
            ],
        );
        return response()->json($task, 201);
    }

    function update($id, \Illuminate\Http\Request $request)
    {
        $d = $request->all();
        $task = Task::findOrFail($id);
        $task->update($d);

        return response()->json($task, 200);
    }

    function delete($id)
    {
        Task::findOrFail($id)->delete();
        return response('Deleted Successfully', 200);
    }
}
