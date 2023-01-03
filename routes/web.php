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

$router->get('/version', function () use ($router) {
    return $router->app->version();
});


Route::group(['prefix' => 'api', 'middleware' => 'auth'], function ($router) {

    Route::get("tasks", "TaskController@getAll");
    Route::post("tasks", "TaskController@create");
    Route::put("tasks/{id}", "TaskController@update");
    Route::delete("tasks/{id}", "TaskController@delete");

    Route::put("projects/{id}", "ProjectController@update");
    Route::post("projects", "ProjectController@create");
    Route::get("projects", "ProjectController@getAll");

    Route::put("shares/{id}", "ShareUsersController@update");
    Route::post("shares", "ShareUsersController@create");
    Route::get("shares/{project_id}", "ShareUsersController@getAll");

});

Route::group(['prefix' => 'api'], function ($router) {
    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('user-profile', 'AuthController@me');
});


