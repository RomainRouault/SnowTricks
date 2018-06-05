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
        //create 5 users
        for ($i = 0; $i < 5; $i++) {
            $user = new User();
            $user->('$user ' . $i);
            $user->setTrickDescription('');
            $user->setTrickCreation(new \DateTime(sprintf('-%d days', rand(1, 100))));

            $trick->persist($trick);
        }

            // create 5 tricks
        for ($i = 0; $i < 5; $i++) {
            $trick = new Trick();
            $trick->setTrickName('trick '.$i);
            $trick->setTrickDescription('An awesome trick');
            $trick->setTrickCreation(new \DateTime(sprintf('-%d days', rand(1, 100))));

            $trick->persist($trick);
        }

        $manager->flush();
    }

}