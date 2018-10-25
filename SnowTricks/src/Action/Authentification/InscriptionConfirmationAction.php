<?php


namespace App\Action\Authentification;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use App\Responder\AuthentificationResponder;
use App\Domain\Form\FormHandler\InscriptionHandler;

class InscriptionConfirmationAction
{
    private $authentificationResponder;
    private $inscriptionHandler;

    public function __construct(AuthentificationResponder $authentificationResponder, InscriptionHandler $inscriptionHandler)
    {
        $this->authentificationResponder = $authentificationResponder;
        $this->inscriptionHandler = $inscriptionHandler;
    }

    /**
     * @Route("/InscriptionConfirmation", name="InscriptionConfirmation")
     *
     */
    public function __invoke(): Response
    {
        $request = Request::createFromGlobals();
        return $this->authentificationResponder->inscriptionConfirmation($this->inscriptionHandler->handleInscriptionConfirmation($request->query->get('token')));
    }

}