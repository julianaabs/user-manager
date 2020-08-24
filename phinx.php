<?php

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/app');
$dotenv->load();

return
    [
        'paths' => [
            'migrations' => '%%PHINX_CONFIG_DIR%%/db/migrations',
            'seeds' => '%%PHINX_CONFIG_DIR%%/db/seeds'
        ],
        'environments' => [
            'default_migration_table' => 'phinxlog',
            'default_environment' => 'development',
            'production' => [
                'adapter' => $_ENV['DATABASE_DRIVER'],
                'host' => $_ENV['DATABASE_HOST'],
                'name' => $_ENV['DATABASE_NAME'],
                'user' => $_ENV['DATABASE_USER'],
                'pass' => $_ENV['DATABASE_PASSWORD'],
                'port' => $_ENV['DATABASE_PORT'],
                'charset' => $_ENV['DATABASE_CHARSET'],
            ],
            'development' => [
                'adapter' => $_ENV['DATABASE_DRIVER'],
                'host' => $_ENV['DATABASE_HOST'],
                'name' => $_ENV['DATABASE_NAME'],
                'user' => $_ENV['DATABASE_USER'],
                'pass' => $_ENV['DATABASE_PASSWORD'],
                'port' => $_ENV['DATABASE_PORT'],
                'charset' => $_ENV['DATABASE_CHARSET'],
            ],
            'testing' => [
                'adapter' => $_ENV['DATABASE_DRIVER'],
                'host' => $_ENV['DATABASE_HOST'],
                'name' => $_ENV['DATABASE_NAME'],
                'user' => $_ENV['DATABASE_USER'],
                'pass' => $_ENV['DATABASE_PASSWORD'],
                'port' => $_ENV['DATABASE_PORT'],
                'charset' => $_ENV['DATABASE_CHARSET'],
            ]
        ],
        'version_order' => 'creation'
    ];
