<?php


namespace App\Controllers;


use DI\Container;

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

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

}