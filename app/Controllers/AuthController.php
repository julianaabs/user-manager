<?php


namespace App\Controllers;


use App\Repositories\UserRepository;
use Psr\Http\Message\ResponseInterface;
use Slim\Psr7\Request;

/**
 * Class AuthController
 * @package App\Controllers
 */
class AuthController extends Controller
{
    /**
     * @var UserRepository
     */
    protected $repository;



    /**
     * @param Request $request
     * @param ResponseInterface $response
     * @return ResponseInterface
     * @throws \DI\DependencyException
     * @throws \DI\NotFoundException
     */
    public function login(Request $request, ResponseInterface $response)
    {
        $values = $request->getParsedBody();
        $auth = $this->container->get('auth')->authenticate($values);

        if (!$auth) {
            $flash = $this->container->get('flash')->addMessage('Authentication Error', 'Email and Password doesn\'t match.');
            return $this->container->get('view')->render($response, 'home.twig');

        }

        return $this->container->get('view')->render($response, 'home.twig');

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
        return $this->getLogin($request, $response);
    }



}