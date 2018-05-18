<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Added prefix of v1.0 as child group of prefix api in order to allow
| future versions to maintain api prefix without need to redeclare it
|
*/


$router->group(['prefix' => 'api'], function () use ($router) {
    $router->group(['prefix' => 'v1.0'], function () use ($router) {
        $router->post('/parseid3', 'ID3\ID3Controller@post');
    });
});