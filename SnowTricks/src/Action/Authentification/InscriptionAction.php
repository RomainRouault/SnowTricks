<?php


namespace App\Action\Authentification;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use App\Responder\AuthentificationResponder;
use App\Domain\Form\FormHandler\InscriptionHandler;


class InscriptionAction
{

    /**
     * @Route("/inscription", name="inscription")
     *
     */
    public function __invoke(AuthentificationResponder $authentificationResponder, InscriptionHandler $inscriptionHandler): Response
    {
        return $authentificationResponder->inscription($inscriptionHandler->handleInscription());
    }
}