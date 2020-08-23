<?php


namespace App\Controllers;


use App\Models\User;
use App\Repositories\UserRepository;
use App\Validators\EmailValidation;
use Psr\Http\Message\ResponseInterface;
use Respect\Validation\Exceptions\ValidationException;
use Slim\Psr7\Request;
use App\Validators\BaseValidator as UserValidator;

/**
 * Class HomeController
 * @package App\Controllers
 */
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




}