<?php

/*
|--------------------------------------------------------------------------
| Application API Routes
|--------------------------------------------------------------------------
|
| All of these routes will require API token.
*/

use Laravel\Lumen\Routing\Router;

/** @var Router $router */
$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group(['prefix' => 'api', 'namespace' => 'Api'], function () use ($router) {
    $router->group(['prefix' => 'v1', 'namespace' => 'v1'], function () use ($router) {
        $router->get('user/{token}', 'UserGetDataController');
        $router->patch('user/{token}', 'UserUpdateDataController');
        $router->post('user/tempo/{token}', 'UserUpdateTempoDataController');
        $router->get('user/tempo/{token}', 'UserGetTempoDataController');
        $router->get('user/report/{token}/{date}', 'UserGetReportController');
    });
});
