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

        $router->get('customer','CustomerController@index');
        $router->post('customer/create','CustomerController@store');
        $router->get('customer/{id}','CustomerController@show');
        $router->get('customer/{id}/edit','CustomerController@edit');
        $router->put('customer/update/{id}','CustomerController@update');
        $router->delete('customer/delete/{id}','CustomerController@destroy');

        $router->get('generic','GenericController@index');
        $router->post('generic/create','GenericController@store');
        $router->get('generic/{id}','GenericController@show');
        $router->get('generic/{id}/edit','GenericController@edit');
        $router->put('generic/update/{id}','GenericController@update');
        $router->delete('generic/delete/{id}','GenericController@destroy');

        $router->get('type','MedicineTypeController@index');
        $router->post('type/create','MedicineTypeController@store');
        $router->get('type/{id}','MedicineTypeController@show');
        $router->get('type/{id}/edit','MedicineTypeController@edit');
        $router->put('type/update/{id}','MedicineTypeController@update');
        $router->delete('type/delete/{id}','MedicineTypeController@destroy');

        $router->get('purchase','PurchaseController@index');
        $router->post('purchase/create','PurchaseController@store');
        $router->get('purchase/{id}','PurchaseController@show');
        $router->get('purchase/{id}/edit','PurchaseController@edit');
        $router->put('purchase/update/{id}','PurchaseController@update');
        $router->delete('purchase/delete/{id}','PurchaseController@destroy');

    });


});

