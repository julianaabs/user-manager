<?php


namespace App\Controllers;


use Psr\Http\Message\ResponseInterface;
use Slim\Http\Request;

/**
 * Class AuthController
 * @package App\Controllers
 */
class AuthController extends Controller
{

    /**
     * @param Request $request
     * @return ResponseInterface
     * @throws \DI\DependencyException
     * @throws \DI\NotFoundException
     */
    public function login(Request $request, $response)
    {
        $values = $request->getParams();
        $auth = $this->container->auth->authenticate($values);

        if (!$auth) {
            $this->container->flash->addMessage('Authentication Error', 'Email and Password doesn\'t match.');
            return $response->withRedirect($this->container->router->pathFor('get-login'));

        }

        $this->container->flash->addMessage('Login Successful', 'Login Successful.');
        return $response->withRedirect($this->container->router->pathFor('home'));

    }

    /**
     * @param Request $request
     * @param ResponseInterface $response
     * @return mixed
     * @throws \DI\DependencyException
     * @throws \DI\NotFoundException
     */
    public function getLogin(Request $request, ResponseInterface $response)
    {
        return $this->container->get('view')->render($response, 'login.twig');
    }

    /**
     * @param Request $request
     * @param ResponseInterface $response
     * @return mixed
     * @throws \DI\DependencyException
     * @throws \DI\NotFoundException
     */
    public function logout(Request $request, ResponseInterface $response)
    {
        $this->container->get('auth')->logout();
        return $response->withRedirect($this->container->router->pathFor('get-login'));
    }



}