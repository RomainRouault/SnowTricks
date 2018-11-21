<?php


namespace App\Action\Authentification;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use App\Responder\AuthentificationResponder;
use App\Domain\Form\FormHandler\InscriptionHandler;

class InscriptionConfirmationAction
{


    /**
     * @Route("/InscriptionConfirmation", name="InscriptionConfirmation")
     *
     */
    public function __invoke(AuthentificationResponder $authentificationResponder, InscriptionHandler $inscriptionHandler, Request $request): Response
    {
        return $authentificationResponder->mailConfirmation($inscriptionHandler->handleInscriptionConfirmation($request->query->get('token')));
    }

}