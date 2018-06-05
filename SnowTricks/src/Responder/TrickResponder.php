<?php
/**
 * Created by PhpStorm.
 * User: Camille & Romain
 * Date: 31/05/2018
 * Time: 14:31
 */

namespace App\Responder;

use Symfony\Component\HttpFoundation\Response;

class TrickResponder extends Responder
{

    public function trickListView(array $trickList = []): Response
    {
        return new Response($this->twig->render('trick/trickList.html.twig', array('trickList' => $trickList)));
    }

}