<?php


namespace App\Action\Trick;

use App\Domain\Repository\TrickRepository;
use App\Responder\TrickResponder;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;


class TrickPage
{
    private $trickResponder;
    private $trickRepository;

    public function __construct(TrickResponder $trickResponder, TrickRepository $trickRepository)
    {
        $this->trickResponder = $trickResponder;
        $this->trickRepository = $trickRepository;
    }

    /**
     * @Route("trick/{slug}", methods={"GET"}, name="trickPage")
     *
     */
    public function __invoke($slug): Response
    {
        return $this->trickResponder->trickDetailsView($this->trickRepository->findOneBySomeField('slug', $slug));
    }

}