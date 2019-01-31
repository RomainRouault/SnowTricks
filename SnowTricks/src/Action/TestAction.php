<?php

namespace App\Action;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\RouterInterface;


class TestAction
{

    public function __construct()
    {
    }


    /**
     * @Route("/test", methods={"GET"}, name="test")
     *
     */
    public function dumpThis(RouterInterface $router)
    {
        $routes = $router->getRouteCollection()->all();
        $paths = array();
        foreach ($routes as $route){
            $paths[] = $route->getPath();
        };

        dd($paths);
    }

}
