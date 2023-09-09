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
    return $router->app->version();
});

$router->get('/users', 'UserController@index');
$router->get('/products','ProductController@index');


$router->group(['middleware' => 'auth'], function() use (&$router){
    $router->post('/user/store', 'UserController@store');
    $router->get('/user/show/{id}', 'UserController@show');
    $router->put('/user/update/{id}', 'UserController@update');
    $router->delete('/user/delete/{id}', 'UserController@destroy');

    // Product
    $router->post('/product/store','ProductController@store');
    $router->get('/product/show/{id}','ProductController@show');
    $router->put('/product/update/{id}', 'ProductController@update');
    $router->delete('/product/delete/{id}', 'ProductController@destroy');
 });


