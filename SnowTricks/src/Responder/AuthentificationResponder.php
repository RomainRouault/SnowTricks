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

    Public function login($form, $error)
    {
        try
        {
            return New Response($this->twig->render('authentification/login.html.twig', ['form' => $form, 'error' => $error]));
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

    Public function account($forms = array(), $relatedData = array())
    {
        try
        {
            return New Response($this->twig->render('authentification/account.html.twig', ['forms' => $forms, 'data' => $relatedData]));
        }

        catch(\Exception $e)
        {
            $e->getMessage();
        }

    }

    public function mailConfirmation(array $confirmation)
    {
        if ($confirmation['success'] == true)
        {
            $this->flashBag->add('validation', $confirmation['message']);
        }

        else
        {
            $this->flashBag->add('error', $confirmation['message']);
        }

        $url = $this->urlGenerator->generate('homepage');
        $http_response_header = new RedirectResponse($url);
        return $http_response_header;

    }


}