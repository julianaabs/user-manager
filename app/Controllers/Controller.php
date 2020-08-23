<?php


namespace App\Controllers;


use App\Validators\BaseValidator;
use Respect\Validation\Validator as UserValidator;
use Slim\Container;
use Slim\Http\Request;

/**
 * Class Controller
 *
 * Base Controller
 * @package App\Controllers
 */
abstract class Controller
{
    /**
     * @var Container
     */
    protected $container;

    public function __construct(Container $container)
    {
        $this->container = $container;

    }

    /**
     * @param Request $request
     * @param array $values
     * @return BaseValidator
     */
    public function getCreateValidator(Request $request, array $values): BaseValidator
    {
        return $this->container->validator->validate($request, [
            'name' => UserValidator::length(6, 30)->alpha(),
            'email' => UserValidator::noWhitespace()->notEmpty()->email(),
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

    /**
     * @param Request $request
     * @param array $values
     * @return BaseValidator
     */
    public function getUpdateValidator(Request $request, array $values): BaseValidator
    {
        return $this->container->validator->validate($request, [
            'name' => UserValidator::length(6, 30)->alpha(),
            'email' => UserValidator::noWhitespace()->notEmpty()->email(),
        ]);
    }

}