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
        // User data
        $router->get('user/{token}', 'UserGetDataController');
        $router->patch('user/{token}', 'UserUpdateDataController');

        // Tempo data
        $router->post('user/tempo/{token}', 'UserUpdateTempoDataController');
        $router->get('user/tempo/{token}', 'UserGetTempoDataController');

        // User reports
        $router->get('user/report/{token}/{date}', 'UserGetReportController');
        $router->post('user/report/generate/{token}/{date}', 'UserGenerateReportController');

        // Teams
        $router->get('team/list/{token}', 'TeamListController');
        $router->get('team/{token}/{team_id}', 'TeamGetDataController');
        $router->patch('team/{token}', 'TeamUpdateDataController');
        $router->delete('team/{token}/{team_id}', 'TeamDeleteController');
    });
});
