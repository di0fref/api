<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    echo "<center> Welcome </center>";
});



Route::group(['prefix' => 'api', 'middleware' => 'auth'], function ($router) {
    Route::get('me', 'UserController@me');

    Route::get("notifications", "NotificationController@getAll");


    Route::get("tasks/{id}", "TaskController@getOne");

    Route::get("tasks", "TaskController@getAll");
    Route::post("tasks", "TaskController@create");
    Route::put("tasks/{id}", "TaskController@update");
    Route::delete("tasks/{id}", "TaskController@delete");
    Route::get("tasks/changes/{id}", "TaskController@getChanges");

    Route::get("projects_users/pending/{email}", "ProjectsUsersController@getPending");

    Route::put("projects/{id}", "ProjectController@update");
    Route::post("projects", "ProjectController@create");
    Route::get("projects", "ProjectController@getAll");
    Route::delete("projects_/{id}", "ProjectController@delete");

    Route::get("projects_users/{project_id}", "ProjectsUsersController@getAll");
    Route::post("projects_users", "ProjectsUsersController@create");
    Route::put("projects_users/{id}", "ProjectsUsersController@update");
    Route::delete("projects_users/{id}", "ProjectsUsersController@delete");

});

Route::group(['prefix' => 'api'], function ($router) {
    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
//    Route::post('me', 'AuthController@me');
});


