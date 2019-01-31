<?php

namespace App\Tests\Action\Trick;


use App\Domain\Entity\Trick;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TrickResponseTest extends WebTestCase
{
    /**
     * @dataProvider provideUrls
     */
    public function testTrickResponseIsUp($url)
    {
        $client = self::createClient();
        $client->request('GET', $url);
        $this->assertTrue($client->getResponse()->isSuccessful());
    }

    //url without slugs
    public function provideUrls()
    {
        return[
            ['/'],
        ];

    }

    //test pages with slug
    public function testTrickPageActionIsUp()
    {

        //get the slugs
        self::bootKernel();
        $tricks = self::$container->get('doctrine')->getRepository(Trick::class)->getTrickList();
        $slugs = array();
        foreach ($tricks as $trick)
        {
            $slugs[] = $trick->getTrickSlug();
        }


        $client = self::createClient();
        foreach ($slugs as $slug) {
            $client->request('GET', '/trick/' . $slug);
            $this->assertTrue($client->getResponse()->isSuccessful());
        }
    }

}
