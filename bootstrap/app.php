<?php
declare(strict_types=1);

use Respect\Validation\Validator;

session_start();

require __DIR__ . '/../vendor/autoload.php';

require __DIR__ . '/../app/settings.php';

$app = new \Slim\App(['settings' => $settings]);

require __DIR__ . '/../app/routes.php';

$container = $app->getContainer();

/**
 * Adding database connection.
 */
$capsule = new \Illuminate\Database\Capsule\Manager;
$capsule->addConnection($container['settings']['db']);
$capsule->setAsGlobal();
$capsule->bootEloquent();

/**
 * Configuring database.
 *
 * @param $container
 * @return \Illuminate\Database\Capsule\Manager
 */
$container['db'] = function ($container) use ($capsule) {
    return $capsule;
};

/**
 * Setting Auth class.
 *
 * @return \App\Models\Auth
 */
$container['auth'] = function () {
    return new \App\Models\Auth();
};

/**
 * Setting CSRF
 *
 * @return \Slim\Csrf\Guard
 */
$container['csrf'] = function () {
    return new Slim\Csrf\Guard;
};

$app->add($container->csrf);

/**
 * Setting flash messages for views.
 *
 * @return \Slim\Flash\Messages
 */
$container['flash'] = function () {
    return new \Slim\Flash\Messages();
};

/**
 * Configuring views.
 *
 * @param $container
 * @return \Slim\Views\Twig
 */
$container['view'] = function ($container) {
    $view = new \Slim\Views\Twig(__DIR__ . '/../resources/views', [
        'cache' => false
    ]);

    $view->addExtension(new \Slim\Views\TwigExtension($container->router, $container->request->getUri));
    $view->addExtension(new \App\Infrastructure\Extensions\CsrfExtension($container->csrf));

    $view->getEnvironment()->addGlobal('auth', [
        'logged' => $container['auth']->logged(),
        'me' => $container['auth']->me()
    ]);

    $view->getEnvironment()->addGlobal('flash', $container->flash);

    return $view;
};

/**
 * Setting Validator
 *
 * @param $container
 * @return \App\Validators\BaseValidator
 */
$container['validator'] = function () {
    return new \App\Validators\BaseValidator;
};

/**
 * Setting controllers.
 *
 * @param $container
 * @return \App\Controllers\HomeController
 */
$container['HomeController'] = function ($container) {

    return new \App\Controllers\HomeController($container);
};
$container['UserController'] = function ($container) {
    return new \App\Controllers\UserController($container);
};
$container['AuthController'] = function ($container) {
    return new \App\Controllers\AuthController($container);
};

