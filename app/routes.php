<?php
declare(strict_types=1);

use App\Application\Actions\User\ListUsersAction;
use App\Application\Actions\User\ViewUserAction;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;

return function (App $app) {
    $app->options('/{routes:.*}', function ($request, $response) {
        // CORS Pre-Flight OPTIONS Request Handler
        return $response;
    });

    $app->get('/', \App\Controllers\HomeController::class . ':index');

//    $app->get('/home', function () {
//        return 'Home';
//    });

    $app->group('/users', function (Group $group) {
        $group->get('', 'UserController:index');
        $group->get('/{id}', ViewUserAction::class);
    });
};
