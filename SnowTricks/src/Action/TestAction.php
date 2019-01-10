<?php

namespace App\Action;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;


class TestAction
{
    private $mailer;

    public function __construct(\Swift_Mailer $mailer)
    {
        $this->mailer = $mailer;
    }


    /**
     * @Route("/test", methods={"GET"}, name="test")
     *
     */
    public function test()
    {

        return new Response('test');

    }

}
