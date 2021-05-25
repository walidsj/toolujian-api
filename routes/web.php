<?php

/** @var \Laravel\Lumen\Routing\Router $router */

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MahasiswaController;

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
    return response()->json([
        'status' => 'online',
        'message' => getenv('APP_NAME', 'API Tool Ujian'),
        'timezone' => date_default_timezone_get(),
        'version' => getenv('APP_VERSION', '1.1.0'),
        'vendor' => $router->app->version()
    ]);
});

$router->group(['prefix' => 'api/v1'], function () use ($router) {

    // public
    $router->post('/auth/login', ['uses' => 'AuthController@authenticate']);

    // restricted
    $router->group(['prefix' => 'mahasiswa', 'middleware' => 'jwt.auth'], function () use ($router) {
        $router->get('/my-profile', ['uses' => 'MahasiswaController@show']);
        $router->get('/my-logs', ['uses' => 'MahasiswaController@log']);
    });
});
