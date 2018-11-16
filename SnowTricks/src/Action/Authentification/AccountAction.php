<?php


namespace App\Action\Authentification;

use App\Domain\Form\FormHandler\UpdateUserHandler;
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
    public function __invoke(AuthentificationResponder $authentificationResponder, UpdateUserHandler $updateUserHandler): Response
    {
        return $authentificationResponder->account($updateUserHandler->buildUpdateForms());
    }
}