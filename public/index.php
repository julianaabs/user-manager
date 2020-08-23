<?php

use App\Application\Handlers\HttpErrorHandler;
use App\Application\Handlers\ShutdownHandler;
use App\Application\ResponseEmitter\ResponseEmitter;
use DI\ContainerBuilder;
use Slim\Factory\AppFactory;
use Slim\Factory\ServerRequestCreatorFactory;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require __DIR__ . '/../vendor/autoload.php';


// Instantiate PHP-DI ContainerBuilder
$containerBuilder = new ContainerBuilder();

if (false) { // Should be set to true in production
	$containerBuilder->enableCompilation(__DIR__ . '/../var/cache');
}

// Set up settings
$settings = require __DIR__ . '/../app/settings.php';
$settings($containerBuilder);

// Set up dependencies
$dependencies = require __DIR__ . '/../app/dependencies.php';
$dependencies($containerBuilder);

// Set up repositories
$repositories = require __DIR__ . '/../app/repositories.php';
$repositories($containerBuilder);

// Build PHP-DI Container instance
$container = $containerBuilder->build();

// Instantiate the app
AppFactory::setContainer($container);
$app = AppFactory::create();
$callableResolver = $app->getCallableResolver();

// Register middleware
$middleware = require __DIR__ . '/../app/middleware.php';
$middleware($app);

// Register routes
$routes = require __DIR__ . '/../app/routes.php';
$routes($app);

/** @var bool $displayErrorDetails */
$displayErrorDetails = $container->get('settings')['displayErrorDetails'];

// Create Request object from globals
$serverRequestCreator = ServerRequestCreatorFactory::create();
$request = $serverRequestCreator->createServerRequestFromGlobals();

// Create Error Handler
$responseFactory = $app->getResponseFactory();
$errorHandler = new HttpErrorHandler($callableResolver, $responseFactory);

// Create Shutdown Handler
$shutdownHandler = new ShutdownHandler($request, $errorHandler, $displayErrorDetails);
register_shutdown_function($shutdownHandler);

// Add Routing Middleware
$app->addRoutingMiddleware();

// Add Error Middleware
$errorMiddleware = $app->addErrorMiddleware($displayErrorDetails, false, false);
$errorMiddleware->setDefaultErrorHandler($errorHandler);


/**
 * Configuring database.
 */
$capsule = new \Illuminate\Database\Capsule\Manager;
$capsule->addConnection($container->get('settings')['db']);
$capsule->setAsGlobal();
$capsule->bootEloquent();
$container->set('db', function ($container) use ($capsule) {
    return $capsule;
});

$container->set('csrf', function () use ($responseFactory) {
    session_start();
    return new Slim\Csrf\Guard($responseFactory);
});


$container->set('auth', function () {
    return new \App\Models\Auth();
});
/**
 * Configuring views.
 */
$container->set('view', function () use ($container, $app) {
    $view = \Slim\Views\Twig::create(__DIR__ . '/../resources/views', [
        'cache' => false
    ]);

    $view->addExtension(new \App\Infrastructure\Extensions\CsrfExtension($container->get('csrf')));

    $view->getEnvironment()->addGlobal('auth', [
        'logged' => $container->get('auth')->logged(),
        'me' => $container->get('auth')->me()
    ]);

    return $view;

});

$container->set('flash',  function () {
    return new \Slim\Flash\Messages();
});

$container->set('repository', function () {
    return new \App\Repositories\BaseRepository();
});


/**
 * Configuring validator.
 */
$container->set('validator', function () {
    return new Awurth\SlimValidation\Validator();
});

/**
 * Configuring Controllers
 */
$container->set('HomeController', function ($container) {
    return new \App\Controllers\HomeController($container->get('view'), $container->get('repository'));
});

//$container->set('router', function () use ($routes, $app) {
//    return new \Illuminate\Support\Facades\Route($routes($app));
//});

$app->add(\Slim\Views\TwigMiddleware::createFromContainer($app));
$app->add($container->get('csrf'));
$app->run();

//
//$app = new \Slim\App($responseFactory);
//$app->get('/hello/{name}', function (Request $request, Response $response, array $args) {
//    $name = $args['name'];
//    $response->getBody()->write("Hello, $name");
//
//    return $response;
//});
//$app->run();
