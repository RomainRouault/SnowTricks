<?php


namespace App\Action\Authentification;

use App\Domain\Form\FormHandler\ResetPasswordHandler;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Responder\AuthentificationResponder;
use Symfony\Component\HttpFoundation\Request;

class ResetPasswordAction
{

    /**
     * @Route("/reinitialiser-mot-de-passe", name="resetPassword")
     */
    public function __invoke( AuthentificationResponder $authentificationResponder, ResetPasswordHandler $resetPasswordHandler): Response
    {
        $request = Request::createFromGlobals();
        return $authentificationResponder->resetPassword($resetPasswordHandler->resetPassword($request->query->get('token')));
    }

}