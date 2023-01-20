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
        $projects = Project::where("projects_users.user_id", Auth::id())
//            ->orderBy("name", "asc")
            ->orderBy("order", "asc")
            ->leftJoin("projects_users", "projects.id", "=", "projects_users.project_id")
            ->whereIn("projects_users.status", ["accepted", "owner"])
//             ->orWhere("projects_users.status", "owner")
            ->select("projects.*")->distinct()->get();


        foreach ($projects as $project){
            $project["users"] = ProjectsUsers::where("projects_users.project_id", $project->id)->select("projects_users.user_id as id")->get();
        }

        return response()->json($projects);
    }

    function create(\Illuminate\Http\Request $request)
    {
        $project = Project::create(array_merge(array("user_id" => Auth::id()), $request->all()));

        ProjectsUsers::create([
                "user_id" => Auth::id(),
                "project_id" => $project->id,
                "shared_user_id" => Auth::id(),
                "status" => "owner",
                "email" => ""
            ]);

        return response()->json($project, 201);
    }

    function update($id, \Illuminate\Http\Request $request)
    {
        $d = $request->all();
        $project = Project::findOrFail($id);
        $project->update($d);

        return response()->json($project, 200);
    }

    public function delete($id, \Illuminate\Http\Request $request)
    {
        $project = Project::findOrFail($id);
//        $project->delete();

        return response()->json($id, 201);

    }
}
