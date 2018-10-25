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

        $message = (new \Swift_Message('Bienvenue sur SnowTricks ' ))
            ->setFrom('rouaults11@gmail.com')
            ->setTo('rrouault11@gmail.com')
            ->setBody('test'
                );



        $this->mailer->send($message);

        return Response::create('Ok');

    }

}
