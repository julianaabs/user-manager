<?php
declare(strict_types=1);

use DI\ContainerBuilder;
use Monolog\Logger;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();


    $settings = [
        'displayErrorDetails' => true, // Should be set to false in production
        'logger' => [
            'name' => 'slim-app',
            'path' => isset($_ENV['docker']) ? 'php://stdout' : __DIR__ . '/../logs/app.log',
            'level' => Logger::DEBUG,
        ],
        'determineRouteBeforeAppMiddleware' => false,
        'db' => [
            'driver' => $_ENV['DATABASE_DRIVER'],
            'host' =>  $_ENV['DATABASE_HOST'],
            'database' => $_ENV['DATABASE_NAME'],
            'username' => $_ENV['DATABASE_USER'],
            'password' => $_ENV['DATABASE_PASSWORD'],
            'charset'   => $_ENV['DATABASE_CHARSET'],
            'collation' => $_ENV['DATABASE_COLLATION'],
            'prefix'    => '',
        ]
    ];
