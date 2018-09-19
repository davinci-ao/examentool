<?php

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

// Routes for DeterminedExamController
$router->get('/index', [
    'uses' => 'DeterminedExamController@index'
]);
$router->get('/view/{id}', [
    'uses' => 'DeterminedExamController@view'
]);
$router->post('/add', [
    'uses' => 'DeterminedExamController@create'
]);