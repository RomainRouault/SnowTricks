<?php


namespace App\Responder;

use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Twig\Environment;
use Symfony\Component\Routing\RouterInterface;


class AuthentificationResponder extends Responder
{
    private $flashBag;
    private $urlGenerator;
    private $router;

    public function __construct(Environment $twig, FlashBagInterface $flashBag, UrlGeneratorInterface $urlGenerator, RouterInterface $router)
    {
        parent::__construct($twig);
        $this->flashBag = $flashBag;
        $this->urlGenerator = $urlGenerator;
        $this->router = $router;

    }

    Public function inscription($form): Response
    {
        try
        {
            return new Response($this->twig->render('authentification/inscription.html.twig', array('form' => $form)));
        }
        catch(\Exception $e)
        {
            $errorMessage = $e->getMessage();
        }

    }

    Public function inscriptionConfirmation($confirmation)
    {
        if ($confirmation)
        {
            $this->flashBag->add('validation', 'Inscription terminée, vous pouvez maintenant profitez de toute les fonctionnalités du site en vous rendant sur "connexion".');
        }

        else
        {
            $this->flashBag->add('error', 'Cet email a déjà été validé.');
        }
        $url = $this->urlGenerator->generate('homepage');
        $http_response_header = new RedirectResponse($url);
        return $http_response_header;
    }

    Public function login($lastUsername, $error)
    {
        try
        {
            return New Response($this->twig->render('authentification/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]));
        }

        catch(\Exception $e)
        {
            $e->getMessage();
        }

    }

    Public function forgotPassword($form)
    {
        try
        {
            return New Response($this->twig->render('authentification/forgotPassword.html.twig', ['form' => $form]));
        }

        catch(\Exception $e)
        {
            $e->getMessage();
        }

    }


    Public function resetPassword($form)
    {
        if ($form)
        {
            try
            {
                return New Response($this->twig->render('authentification/resetPassword.html.twig', ['form' => $form]));
            }
            catch (\Exception $e)
            {
                $e->getMessage();
            }
        }

        return new RedirectResponse($this->router->generate('homepage'));
    }

    Public function account()
    {
        try
        {
            return New Response($this->twig->render('authentification/account.html.twig'));
        }

        catch(\Exception $e)
        {
            $e->getMessage();
        }

    }

}