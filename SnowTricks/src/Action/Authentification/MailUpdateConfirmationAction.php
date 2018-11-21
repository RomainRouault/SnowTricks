<?php


namespace App\Action\Authentification;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use App\Responder\AuthentificationResponder;
use App\Domain\Form\FormHandler\UpdateUserHandler;


class MailUpdateConfirmationAction
{
    /**
     * @Route("/MailUpdateConfirmation", name="MailUpdate")
     *
     */
    public function __invoke(AuthentificationResponder $authentificationResponder, UpdateUserHandler $updateUserHandler, Request $request): Response
    {
        return $authentificationResponder->mailConfirmation($updateUserHandler->handleMailUpdateConfirmation($request->query->get('token')));
    }


}