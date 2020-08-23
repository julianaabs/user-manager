<?php


namespace App\Controllers;


use App\Models\User;
use App\Repositories\UserRepository;
use Psr\Http\Message\ResponseInterface;
use Slim\Psr7\Request;

/**
 * Class UserController
 * @package App\Controllers
 */
class UserController extends Controller
{
    /**
     * @var UserRepository
     */
    protected $repository;

    public function index($request, ResponseInterface $response)
    {
        return $this->container->get('view')->render($response, 'home.twig');
    }


    /**
     * @param Request $request
     * @param ResponseInterface $response
     * @return ResponseInterface
     * @throws \DI\DependencyException
     * @throws \DI\NotFoundException
     */
    public function create(Request $request, ResponseInterface $response)
    {
        $values = $request->getParsedBody();

        $validator = $this->getValidator($request, $values);

        if ($validator->isValid()) {
            User::query()->create([
                'name' => $values['name'],
                'email' => $values['email'],
                'password' => password_hash($values['password'], PASSWORD_BCRYPT, ['cost' => 10])
            ]);

        } else {
            // @todo print errors
            $errors = $validator->getErrors();
            var_dump($errors);
            die;
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
    public function list(Request $request, ResponseInterface $response)
    {
        $users = [];
        foreach (User::all() as $user) {
            $users[] = [
                'name' => $user->name,
                'email' => $user->email
            ];
        }

        return $this->container->get('view')->render($response, 'users.twig', ['users' => $users]);

    }

    /**
     * @param Request $request
     * @param ResponseInterface $response
     * @return mixed
     * @throws \DI\DependencyException
     * @throws \DI\NotFoundException
     */
    public function getEdit(Request $request, ResponseInterface $response)
    {
        $user = User::query()->find($_SESSION['user']);
        return $this->container->get('view')->render($response, 'edit.twig', ['user' => $user->getKey()]);
    }

    /**
     * @param Request $request
     * @param ResponseInterface $response
     * @return mixed
     * @throws \DI\DependencyException
     * @throws \DI\NotFoundException
     */
    public function update(Request $request, ResponseInterface $response)
    {
        $values = $request->getParsedBody();

        $validator = $this->getValidator($request, $values);

        $user = User::query()->find($_SESSION['user']);

        $this->repository->setModel($user);

//        if ($validator->isValid()) {
//            $this->repository->update($values, $user->getKey());
//
//        } else {
//            // @todo print errors
//            $errors = $validator->getErrors();
//            var_dump($errors);
//            die;
//        }


        return $this->container->get('view')->render($response, 'home.twig');

    }

}