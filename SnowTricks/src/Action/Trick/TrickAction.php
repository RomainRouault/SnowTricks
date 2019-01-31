<?php


namespace App\Action\Trick;

use App\Domain\Repository\TrickRepository;
use App\Responder\TrickResponder;


class TrickAction
{
    protected $trickResponder;
    protected $trickRepository;

    public function __construct(TrickResponder $trickResponder, TrickRepository $trickRepository)
    {
        $this->trickResponder = $trickResponder;
        $this->trickRepository = $trickRepository;
    }

}