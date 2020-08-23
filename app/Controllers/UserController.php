<?php


namespace App\Controllers;


use App\Models\User;
use App\Validators\BaseValidator;
use Awurth\SlimValidation\Validator;
use Illuminate\Database\QueryException;
use Illuminate\Support\Arr;
use Psr\Http\Message\ResponseInterface;
use Respect\Validation\Validator as V;

use Slim\Http\Request;

/**
 * Class UserController
 * @package App\Controllers
 */
class UserController extends Controller
{

    /**
     * @param Request $request
     * @param ResponseInterface $response
     * @return ResponseInterface
     */
    public function create(Request $request, ResponseInterface $response)
    {
        $values = $request->getParsedBody();

        $validator = $this->getCreateValidator($request, $values);

        if ($validator->isValid()) {
            try {
                $user = User::query()->create([
                    'name' => $values['name'],
                    'email' => $values['email'],
                    'password' => password_hash($values['password'], PASSWORD_BCRYPT, ['cost' => 10])
                ]);
            } catch (QueryException $exception) {
                $this->container->flash->addMessage('Register Error', 'Incorrect data, review the fields');
                return $response->withRedirect($this->container->router->pathFor('home'));
            }

            $this->container->auth->authenticate(Arr::only($values, ['email', 'password']));

        } else {
            $this->container->flash->addMessage('Register Error', 'Incorrect data, review the fields');
        }

        return $response->withRedirect($this->container->router->pathFor('home'));
    }

    /**
     * @param Request $request
     * @param ResponseInterface $response
     * @return mixed
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
        return $this->container->get('view')->render($response, 'edit.twig', ['user' => $user]);
    }

    /**
     * @param Request $request
     * @param ResponseInterface $response
     * @return mixed
     */
    public function update(Request $request, ResponseInterface $response)
    {
        $values = $request->getParsedBody();
        var_dump($values);
        unset($values['csrf_name'], $values['csrf_value']);

        try {
            User::query()->where('id', $_SESSION['user'])->update($values);
        } catch (\Exception $exception) {
            $this->container->flash->addMessage('Edit Error', 'Error editing, review the fields.');
            return $response->withRedirect($this->container->router->pathFor('get-edit'));
        }

        return $response->withRedirect($this->container->router->pathFor('home'));

    }

    /**
     * @param Request $request
     * @param ResponseInterface $response
     * @return mixed
     */
    public function delete(Request $request, ResponseInterface $response)
    {
        $values = $request->getParsedBody();
        unset($values['csrf_name'], $values['csrf_value']);

        User::query()->where('id', $_SESSION['user'])->update($values);

        return $response->withRedirect($this->container->router->pathFor('home'));

    }

}