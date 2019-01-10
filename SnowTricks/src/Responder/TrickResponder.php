<?php

namespace App\Responder;

use Symfony\Component\HttpFoundation\Response;

class TrickResponder extends Responder
{

    public function trickListView(array $trickList = []): Response
    {
        return new Response($this->twig->render('trick/trickList.html.twig', array('trickList' => $trickList)));
    }

    public function trickDetailsView($trickDetails): Response
    {
        return new Response($this->twig->render('trick/trick_details.html.twig', array('trickDetails' => $trickDetails)));
    }

}