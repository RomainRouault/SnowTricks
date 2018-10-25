<?php


namespace App\Action\Authentification;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use App\Responder\AuthentificationResponder;
use App\Domain\Form\FormHandler\InscriptionHandler;


class InscriptionAction
{
    private $authentificationResponder;
    private $inscriptionHandler;

    public function __construct(AuthentificationResponder $authentificationResponder, InscriptionHandler $inscriptionHandler)
    {
        $this->authentificationResponder = $authentificationResponder;
        $this->inscriptionHandler = $inscriptionHandler;
    }

    /**
     * @Route("/inscription", name="inscription")
     *
     */
    public function __invoke(): Response
    {
        return $this->authentificationResponder->inscription($this->inscriptionHandler->handleInscription());
    }
}