<?php


namespace App\Controllers;


use App\Models\User;
use App\Repositories\UserRepository;
use Psr\Http\Message\ResponseInterface;
use Slim\Psr7\Request;

class HomeController extends Controller
{

    /**
     * @var UserRepository
     */
    protected $repository;


    public function index($request, ResponseInterface $response)
    {

        return $this->container->get('view')->render($response, 'home.twig');
    }

    public function create(Request $request, ResponseInterface $response)
    {
        $values = $request->getParsedBody();

        // @todo create an action
        User::query()->create([
            'name' => $values['name'],
            'email' => $values['email'],
            'password' => password_hash($values['password'], PASSWORD_BCRYPT, ['cost' => 10])
        ]);

        return $response
            ->withHeader('Location', $this->container->get('router')->getPathFor('home'))
            ->withStatus(302);
    }


}