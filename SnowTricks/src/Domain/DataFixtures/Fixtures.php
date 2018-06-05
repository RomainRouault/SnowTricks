<?php
/**
 * Created by PhpStorm.
 * User: Camille & Romain
 * Date: 04/06/2018
 * Time: 16:36
 */

// src/domain/DataFixtures/Fixtures.php
namespace App\Domain\DataFixtures;

use App\Domain\Entity\Trick;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;


class Fixtures extends Fixture
{

    public function load(ObjectManager $manager)
    {
        // create 10 tricks
        for ($i = 0; $i < 10; $i++) {
            $trick = new Trick();
            $trick->setTrickName('trick '.$i);
            $trick->persist($trick);
        }

        $manager->flush();
    }

}