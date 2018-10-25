<?php
/**
 * Created by PhpStorm.
 * User: Camille & Romain
 * Date: 04/06/2018
 * Time: 16:36
 */


// src/domain/DataFixtures/Fixtures.php
namespace App\Domain\DataFixtures;

use App\Domain\Entity\Category;
use App\Domain\Entity\Comment;
use App\Domain\Entity\Illustration;
use App\Domain\Entity\Trick;
use App\Domain\Entity\User;
use App\Domain\Entity\Video;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class Fixtures extends Fixture
{

    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {

        for ($i = 1; $i < 6; $i++) {
            //create 5 users
            $user = new User;
            $user->setUserPseudo('User' . $i);
            $user->setUserMail('User' . $i . '@mail.com');
            $password = $this->encoder->encodePassword($user, 'Pass' . $i);
            $user->setUserPass($password);
            $user->setUserPhoto('default-profil.jpg');
            $user->setUserConfirmed(true);

            //create 5 categories
            $category = new Category();
            $category->setCategoryName('Category' . $i);

            // create 5 tricks
            $trick = new Trick();
            $trick->setTrickName('Trick ' . $i);
            //pick a random description
            $descriptions = array('An awesome trick to shine on the slopes!', 'A great trick for confirmed snowboarder.', 'The 1080° classical!', 'A trick in which the rider\'s rear hand grabs the heel side of the board front for the front bindings.', 'The front hand grabs the toe edge in between the feet and the front knee is pulled to the board.');
            $rand = array_rand($descriptions, 1);
            $trick->setTrickDescription( $descriptions[$rand]);
            $crea = $trick->setTrickCreation(new \DateTime(sprintf('-%d days', rand(50, 100))));
            $trick->setUser($user);
            $trick->setCategory($category);

            // create 5 comments
            $comment = new Comment();
            $comment->setCommentCreation(new \DateTime(sprintf('-%d days', rand(1, 49))));
            //pick a random comment
            $comments = array('I know how to make this trick. It\'s pretty easy.', 'What an impossible Trick! For pro only.');
            $rand = array_rand($comments , 1);
            $comment->setCommentContent($comments[$rand]);
            $comment->setUser($user);
            $comment->setTrick($trick);

            // create 5 videos
            $video = new Video();
            $video->setVideoName($trick->getTrickName() . '-Video');
            //pick a random video
            $videos = array('https://youtu.be/CzDjM7h_Fwo', 'https://youtu.be/ejWLQXRJ7Qw', 'https://youtu.be/2vXns5BJ__U');
            $rand = array_rand($videos, 1);
            $video->setVideoUrl($videos[$rand]);
            $video->setTrick($trick);

            // create 5 illustration
            $illustration = new Illustration();
            $illustration->setIllustrationName($trick->getTrickName() . '-Illustration');
            $illustration->setIllustrationUrl('illustration' . $i . '.jpg');
            $illustration->setIllustrationIsMain(true);
            $illustration->setTrick($trick);

            $entities = array($user, $category, $trick, $comment, $video, $illustration);

            // persist the objects for each loop
            foreach ($entities as $entity) {
                $manager->persist($entity);
            }

        }

        $manager->flush();
    }


}