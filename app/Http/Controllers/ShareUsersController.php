<?php

namespace App\Http\Controllers;

use App\Models\ProjectsUsers;
use App\Models\ShareUsers;
use App\Models\User;
use Laravel\Lumen\Routing\Controller as BaseController;

class ShareUsersController extends BaseController
{
    function getAll(\Illuminate\Http\Request $request)
    {

        $shares = ShareUsers::where("project_id", $request->project_id)
            ->where("status", "pending")
            ->get();


        $project_users = ProjectsUsers::where("project_id", $request->project_id )

            ->leftJoin("users", "users.id", "=", "projects_users.user_id")->distinct()

            ->get();

        return response()->json(
            [
                "shares" => $shares,
                "project_users" => $project_users
            ]
        );

    }

    function update($id, \Illuminate\Http\Request $request)
    {

        $share = ShareUsers::findOrFail($id);
        $share->update($request->all());

        return response()->json($share);
    }

    function create(\Illuminate\Http\Request $request)
    {
        $user = User::where("email", $request->get("email"))->first();

        if ($user) {
            ProjectsUsers::create(
                array(
                    "user_id" => $user->id,
                    "project_id" => $request->get("project_id")
                )
            );
        }
        $share = ShareUsers::create(
            array_merge($request->all(), ["status" => "accepted"])
        );

        return response()->json($share);
    }
}
