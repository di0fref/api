<?php

namespace App\Http\Controllers;

use App\Models\ShareUsers;
use Laravel\Lumen\Routing\Controller as BaseController;

class ShareUsersController extends BaseController
{
    function getAll(\Illuminate\Http\Request $request){

        $shares = ShareUsers::where("project_id", $request->project_id)->get();
        return response()->json(
            $shares
        );
    }

    function update($id, \Illuminate\Http\Request $request){

        $share = ShareUsers::findOrFail($id);
        $share->update($request->all());

        return response()->json(
            $share
        );
    }

    function add(\Illuminate\Http\Request $request){

    }
}
