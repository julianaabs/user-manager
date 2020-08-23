<?php
declare(strict_types=1);

use Slim\App;

return function (App $app) {
    $app->options('/{routes:.*}', function ($request, $response) {
        // CORS Pre-Flight OPTIONS Request Handler
        return $response;
    });


    $app->get('/', \App\Controllers\HomeController::class . ':index')->setName('home');
    $app->post('/create-user', \App\Controllers\UserController::class . ':create')->setName('create-user');
    $app->get('/login', \App\Controllers\AuthController::class. ':getLogin')->setName('get-login');
    $app->post('/login', \App\Controllers\AuthController::class. ':login')->setName('login');
    $app->get('/logout', \App\Controllers\AuthController::class. ':logout')->setName('logout');
    $app->get('/users', \App\Controllers\UserController::class. ':list')->setName('list');
    $app->get('/edit', \App\Controllers\UserController::class. ':getEdit')->setName('get-edit');
    $app->patch('/update', \App\Controllers\UserController::class. ':update')->setName('update');


};
