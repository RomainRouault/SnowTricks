<?php


namespace App\Action\Authentification;

use App\Domain\Form\FormHandler\LoginHandler;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use App\Responder\AuthentificationResponder;


class LoginAction
{

    /**
     * @Route("/login", name="login")
     */
    public function __invoke(AuthenticationUtils $authenticationUtils, AuthentificationResponder $authentificationResponder, LoginHandler $loginHandler): Response
    {
        // last username entered by the user
       $lastUsername = $authenticationUtils->getLastUsername();
       // get last authentication errors
        $error = $authenticationUtils->getLastAuthenticationError();

        return $authentificationResponder->login($loginHandler->buildForm($lastUsername), $error);
    }

}