<?php


namespace App\Action\Trick;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TrickPageAddTrickAction extends TrickAction
{

    /**
     * @Route("/ajout-", methods={"GET"}, name="homepage")
     *
     */
    public function __invoke(): Response
    {
        return $this->trickResponder->trickListView($this->trickRepository->getTrickList());
    }

}