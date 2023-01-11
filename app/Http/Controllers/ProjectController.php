<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\ProjectsUsers;
use Illuminate\Support\Facades\Auth;
use function response;

class ProjectController extends Controller
{
    function getAll(\Illuminate\Http\Request $request)
    {
        $project = Project::where("projects_users.user_id", Auth::id())
//            ->orderBy("name", "asc")
            ->orderBy("order", "asc")
            ->leftJoin("projects_users", "projects.id", "=", "projects_users.project_id")
            ->select("projects.*")->get();

        return response()->json(
            $project
        );
    }

    function create(\Illuminate\Http\Request $request)
    {
        $project = Project::create(
            array_merge(array("user_id" => Auth::id()), $request->all())
        );

        ProjectsUsers::create(
            [
                "user_id" => Auth::id(),
                "project_id" => $project->id,
                "shared_user_id" =>  Auth::id(),
                "status" => "owner",
                "email" => ""
            ]
        );

        return response()->json($project, 201);
    }

    function update($id, \Illuminate\Http\Request $request)
    {
        $d = $request->all();
        $project = Project::findOrFail($id);
        $project->update($d);

        return response()->json($project, 200);
    }
}
