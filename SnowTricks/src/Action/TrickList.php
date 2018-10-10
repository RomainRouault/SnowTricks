<?php

namespace App\Action;

use App\Domain\Repository\TrickRepository;
use App\Responder\TrickResponder;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;


class TrickList
{
    private $trickResponder;
    private $trickRepository;

    public function __construct(TrickResponder $trickResponder, TrickRepository $trickRepository)
    {
        $this->trickResponder = $trickResponder;
        $this->trickRepository = $trickRepository;
    }

    /**
     * @Route("/", methods={"GET"}, name="homepage")
     *
     */
    public function __invoke(): Response
    {
        return $this->trickResponder->trickListView($this->trickRepository->getTrickList());
    }
}