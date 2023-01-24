<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\NotificationsUsers;
use App\Models\ProjectsUsers;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Lumen\Routing\Controller as BaseController;
use App\Models\Project;


class ProjectsUsersController extends BaseController
{
    function getAll(\Illuminate\Http\Request $request)
    {

        $project_users = ProjectsUsers::where("project_id", $request->project_id)
            ->whereIn("status", ["accepted", "owner"])
            ->leftJoin("users", "users.id", "=", "projects_users.user_id")
            ->distinct()
            ->selectRaw("projects_users.status,
                CASE WHEN projects_users.email = '' THEN users.email ELSE projects_users.email END as email,
                projects_users.id,
                users.id as user_id,
                users.name,
                users.image_url,
                projects_users.project_id,
                projects_users.shared_user_id")
            ->orderByRaw("FIELD(status , 'owner', 'pending', 'accepted') ASC")->get();

        return response()->json($project_users);

    }

    function delete($id, \Illuminate\Http\Request $request)
    {
        ProjectsUsers::findOrFail($id)->delete();
        return response()->json(["id" => $id], 200);
    }

    function update($id, \Illuminate\Http\Request $request)
    {
        $share = ProjectsUsers::findOrFail($id);

        if ($share->status === "pending" and $request->get("status") === "accepted") {
            $notification = Notification::create([
                "action" => "joined",
                "module" => "Project",
                "module_id" => $request->get("module_id"),
                "user_id" => Auth::id(),
                "by_user_id" => Auth::id(),
            ]);


            $project_users = ProjectsUsers::where("project_id", $request->get("module_id"))->get();

            foreach ($project_users as $project_user) {
                NotificationsUsers::create([
                    "user_id" => $project_user->user_id,
                    "notification_id" => $notification->id
                ]);
            }

        }

        $share->update($request->all());

        return response()->json($share);
    }

    public function getPending($email)
    {
        $shares = ProjectsUsers::where("email", $email)
            ->where("status", "pending")
            ->leftJoin("projects", "projects_users.project_id", "=", "projects.id")
            ->select("*", "projects_users.id as id", "projects.name as project_name")
            ->get();
        return response()->json($shares);
    }


    function create(\Illuminate\Http\Request $request)
    {
        $user = User::where("email", $request->get("email"))->first();

        $share = ProjectsUsers::create(array(
            "user_id" => $user?->id,
            "project_id" => $request->get("project_id"),
            "email" => $request->get("email"),
            "status" => "pending",
            "shared_user_id" => $request->get("shared_user_id"),
        ));

        return response()->json($share);
    }


}
