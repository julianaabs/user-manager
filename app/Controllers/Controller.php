<?php


namespace App\Controllers;


use App\Repositories\BaseRepository;
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

    /**
     * @var BaseRepository
     */
    protected $repository;

    public function __construct(Container $container, BaseRepository $repository)
    {
        $this->container = $container;
        $this->repository = $repository;
    }

}