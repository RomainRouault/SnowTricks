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
use App\Domain\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
//use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class Fixtures extends Fixture
{

    private $encoder;

    /*public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }*/

    public function load(ObjectManager $manager)
    {

        for ($i = 0; $i < 5; $i++) {
            //create 5 users
            $user = new User;
            $user->setUserPseudo('User'. $i);
            $user->setUserMail('User'. $i .'@mail.com');
            $user->setUserPass();
            // create 5 tricks
            $trick = new Trick();
            $trick->setTrickName('Trick ' . $i);
            $trick->setTrickDescription(array_rand(array('An awesome trick to shine on the slopes!', 'A great trick for confirmed snowboarder.', 'The 1080° classical!', 'A trick in which the rider\'s rear hand grabs the heel side of the board front for the front bindings.', 'The front hand grabs the toe edge in between the feet and the front knee is pulled to the board.'), 1));
            $trick->setTrickCreation(new \DateTime(sprintf('-%d days', rand(1, 100))));

            $manager->persist($trick);
        }

        $manager->flush();
    }


}

