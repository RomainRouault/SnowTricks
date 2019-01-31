<?php


namespace App\Tests\Domain\DataFixtures;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class FixturesTest extends WebTestCase
{

    public function testFixturesHomepage()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');
        //test title presence
        $this->assertNotNull( $crawler->filter('h2'));
        //test content presence
        $this->assertSame(5, $crawler->filter('ul.trickContent > li:first-child')->count());
    }

    public function testFixturesTrickPage()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/trick/Trick-1');
        //test title presence
        $this->assertNotNull( $crawler->filter('h2'));
        //test text-content presence
        $this->assertNotNull( $crawler->filter('.text-content')->children());
        //test media presence
        $this->assertNotNull( $crawler->filter('.media'));
        //test img presence
        $this->assertNotNull( $crawler->filter('.media img'));
        //test video presence
        $this->assertNotNull( $crawler->filter('.media iframe'));
        //test comment presence
        $this->assertNotNull( $crawler->filter('ul.comments-list > li'));
    }

}