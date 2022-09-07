<?php

/** @var \Laravel\Lumen\Routing\Router $router */

use Illuminate\Support\Facades\App;
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

// $router->get('/', function () use ($router) {
//     return $router->app->version();
// });


$router->get('/',"weather@test");

$router->post('/get_forecast',"Task1@get_forecast");

$router->get('/logic_system_modul',"Task2@logic_system_modul");
