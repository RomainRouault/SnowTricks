<?php


namespace App\Action\Authentification;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use App\Responder\AuthentificationResponder;


class LoginAction
{
    private $authentificationResponder;

    public function __construct(AuthentificationResponder $authentificationResponder)
    {
        $this->authentificationResponder = $authentificationResponder;
    }

    /**
     * @Route("/login", name="login")
     */
    public function __invoke(AuthenticationUtils $authenticationUtils): Response
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->authentificationResponder->login($lastUsername, $error);
    }

}