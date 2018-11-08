<?php


namespace App\Action\Authentification;

use App\Domain\Form\FormHandler\ResetPasswordHandler;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Responder\AuthentificationResponder;


class ForgotPasswordAction
{

    /**
     * @Route("/mot-de-passe-oublie", name="forgotPassword")
     */
    public function __invoke(AuthentificationResponder $authentificationResponder, ResetPasswordHandler $resetPasswordHandler): Response
    {
        return $authentificationResponder->forgotPassword($resetPasswordHandler->ForgotPassword());
    }

}