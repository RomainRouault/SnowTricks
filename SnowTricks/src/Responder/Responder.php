<?php
/**
 * Created by PhpStorm.
 * User: Camille & Romain
 * Date: 31/05/2018
 * Time: 15:25
 */

namespace App\Responder;

use Twig\Environment;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;



abstract class Responder
{
    /** @var  Environment */
    protected $twig;
    protected $flashBag;
    protected $urlGenerator;

    /**
     * Responder constructor.
     * @param Environment $twig
     */
    public function __construct(Environment $twig, FlashBagInterface $flashBag, UrlGeneratorInterface $urlGenerator)
    {
        $this->twig = $twig;
        $this->flashBag = $flashBag;
        $this->urlGenerator = $urlGenerator;

    }

    /*
     * Method for redirect user to homepage;
     */
    public function redirectToHomePage()
    {
        $url = $this->urlGenerator->generate('homepage');
        $http_response_header = new RedirectResponse($url);
        return $http_response_header;
    }

}