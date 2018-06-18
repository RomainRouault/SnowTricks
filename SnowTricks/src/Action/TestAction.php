<?php

namespace App\Action;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;


class TestAction
{


    /**
     * @Route("/test", methods={"GET"}, name="test")
     *
     */
    public function test()
    {

                $date = new \DateTime(sprintf('-%d days', rand(50, 100)));
                dump($date);

    }

}
