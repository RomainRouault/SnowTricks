<?php


namespace App\Action\Authentification;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use App\Responder\AuthentificationResponder;


class AccountAction
{
    /**
     * @Route ("/compte", name="account")
     * @IsGranted("ROLE_USER")
     *
     */
    public function __invoke(AuthentificationResponder $authentificationResponder): Response
    {
        return $authentificationResponder->account();
    }
}