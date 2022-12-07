<?php

namespace App\Http\Controllers;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;
use function response;

class ProjectController extends Controller
{
    function getAll(\Illuminate\Http\Request $request){
        $project = Project::where("user_id", Auth::id())
            ->orderBy("name", "asc")
            ->orderBy("order", "asc")
            ->get();

        return response()->json(
            $project
        );

    }

    function create(\Illuminate\Http\Request $request){
        $project = Project::create(
            array_merge(array("user_id" => Auth::id(),), $request->all())
        );
        return response()->json($project, 201);
    }
}
