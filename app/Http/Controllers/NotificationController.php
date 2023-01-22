<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\Project;
use App\Models\ProjectsUsers;
use App\Models\Task;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use function response;

class NotificationController extends Controller
{
    function getAll(\Illuminate\Http\Request $request)
    {

        $notifications = Notification::leftJoin("projects_users", "projects_users.project_id", "=", "notifications.module_id")
            ->leftJoin("users", "users.id", "=", "notifications.user_id")
            ->where("projects_users.user_id", Auth::id())
            ->select("notifications.*")->get();

        foreach ($notifications as $notification) {
            $notification["user"] = User::findOrFail($notification->user_id);
            if ($notification->module === "Project") {
                $notification["bean"] = Project::findOrFail($notification->module_id);
            }
            if ($notification->module === "Task") {
                $notification["bean"] = Task::findOrFail($notification->module_id);
            }
        }


        $shares = ProjectsUsers::where("projects_users.email", Auth::user()->email)
            ->where("status", "pending")
            ->leftJoin("projects", "projects_users.project_id", "=", "projects.id")
            ->leftJoin("users", "projects_users.shared_user_id", "=", "users.id")
            ->select("*", "projects_users.id as id", "users.name as action_user_name", "users.image_url", "projects.name as project_name")
            ->get();

        $response = [
            "notifications" => $notifications,
            "shares" => $shares
        ];

        return response()->json($response, 201);
    }
}
