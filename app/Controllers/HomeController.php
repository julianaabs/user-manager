<?php


namespace App\Controllers;


use Psr\Http\Message\ResponseInterface;

/**
 * Class HomeController
 * @package App\Controllers
 */
class HomeController extends Controller
{


    /**
     * @param $request
     * @param ResponseInterface $response
     * @return mixed
     */
    public function index($request, ResponseInterface $response)
    {
        return $this->container->get('view')->render($response, 'home.twig');
    }




}