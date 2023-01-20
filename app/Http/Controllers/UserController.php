<?php

namespace App\Http\Controllers;

use App\Models\User;
use function response;

class UserController extends Controller
{
    public function getUser($id)
    {
        $user = User::findOrFail($id);

        unset($user["password"]);

        return response()->json($user, 201);
    }
}
