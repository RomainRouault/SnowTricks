<?php


namespace App\Responder;

use Symfony\Component\HttpFoundation\Response;


class AuthentificationResponder extends Responder
{

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
            return New Response($this->twig->render('forgot_password.html.twig', ['form' => $form]));
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
                return New Response($this->twig->render('reset_password.html.twig', ['form' => $form]));
            }
            catch (\Exception $e)
            {
                $e->getMessage();
            }
        }

        return $this->redirectToHomePage();
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

        return $this->redirectToHomePage();

    }


}