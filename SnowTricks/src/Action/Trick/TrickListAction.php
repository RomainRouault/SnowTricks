<?php

namespace App\Action\Trick;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class TrickListAction extends TrickAction
{

    /**
     * @Route("/", methods={"GET"}, name="homepage")
     *
     */
    public function __invoke(): Response
    {
        return $this->trickResponder->trickListView($this->trickRepository->getTrickList());
    }

}