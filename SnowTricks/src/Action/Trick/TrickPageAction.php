<?php


namespace App\Action\Trick;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;


class TrickPageAction extends TrickAction
{

    /**
     * @Route("trick/{slug}", methods={"GET"}, name="trickPage")
     *
     */
    public function __invoke($slug): Response
    {
        return $this->trickResponder->trickDetailsView($this->trickRepository->findOneBySomeField('trickSlug', $slug));
    }

}