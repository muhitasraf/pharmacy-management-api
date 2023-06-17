<?php

/** @var \Laravel\Lumen\Routing\Router $router */

// use App\Http\Controllers\UserController;

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
$router->get('/', function () {
    return response()->json([
        'success' => 'true',
        'message' => 'There is no data!',
    ]);
});
$router->group(['prefix'=>'api/v1'], function () use ($router) {
    // return $router->app->version();
    // $router->get('user/create',[UserController::class, 'create']);

    $router->get('user','UserController@index');
    $router->post('user/create','UserController@create');
});
