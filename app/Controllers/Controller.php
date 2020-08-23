<?php


namespace App\Controllers;


use App\Repositories\BaseRepository;
use App\Validators\BaseValidator as UserValidator;
use DI\Container;
use Slim\Psr7\Request;

/**
 * Class Controller
 * @package App\Controllers
 */
class Controller
{

    /**
     * @var Container
     */
    protected $container;

    /**
     * @var BaseRepository
     */
    protected $repository;

    public function __construct(Container $container, BaseRepository $repository)
    {
        $this->container = $container;
        $this->repository = $repository;

    }

    public function getValidator(Request $request, array $values)
    {
        return $this->container->get('validator')->validate($request, [
            'name' => UserValidator::length(6, 30)->alpha(),
            'email' => UserValidator::notBlank()->email(),
            'password' => [
                'rules' => UserValidator::length(6, 20),
                'messages' => [
                    'length' => 'The password must have from 6 to 20 characters.'
                ]
            ],
            'psw-repeat' => [
                'rules' => UserValidator::equals($values['password']),
                'messages' => [
                    'equals' => 'The passwords doesn\'t match.'
                ]
            ]
        ]);
    }

}