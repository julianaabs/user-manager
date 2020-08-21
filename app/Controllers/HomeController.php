<?php


namespace App\Controllers;


use Psr\Http\Message\ResponseInterface;
use Slim\Views\Twig as View;

class HomeController extends Controller
{


    public function index($request, ResponseInterface $response)
    {

        $this->container->get('db')->table('users')->get();
        die();
        return $this->container->get('view')->render($response, 'home.twig');
    }


}