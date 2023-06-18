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

$router->get('/', function () {
    return response()->json([
        'success' => 'true',
        'message' => 'There is no data!',
    ]);
});

$router->group(['prefix'=>'api/v1'], function () use ($router) {

    $router->post( '/login', 'AuthController@login');

    $router->group(['middleware' => 'auth:api'], function( $router ) {
        // User Functions
        $router->get( '/logout', 'AuthController@logout' );
        $router->post( '/logout', 'AuthController@logout' );
        $router->get( '/refresh', 'AuthController@refresh' );
        $router->post( '/refresh', 'AuthController@refresh' );

        $router->get('me','AuthController@me');
        $router->get('user','UserController@index');
        $router->post('user/create','UserController@create');

        $router->get('brands','BrandController@index');
        $router->post('brands/create','BrandController@store');
        $router->get('brands/{id}','BrandController@show');
        $router->get('brands/{id}/edit','BrandController@edit');
        $router->put('brands/update/{id}','BrandController@update');
        $router->delete('brands/delete/{id}','BrandController@destroy');

        $router->get('company','CompanyController@index');
        $router->post('company/create','CompanyController@store');
        $router->get('company/{id}','CompanyController@show');
        $router->get('company/{id}/edit','CompanyController@edit');
        $router->put('company/update/{id}','CompanyController@update');
        $router->delete('company/delete/{id}','CompanyController@destroy');

    });


});

