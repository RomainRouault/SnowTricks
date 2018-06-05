<?php
/**
 * Created by PhpStorm.
 * User: Camille & Romain
 * Date: 31/05/2018
 * Time: 15:25
 */

namespace App\Responder;

use Twig\Environment;

abstract class Responder
{
    /** @var  Environment */
    protected $twig;

    /**
     * Responder constructor.
     * @param Environment $twig
     */
    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

}