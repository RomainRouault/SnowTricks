<?php


namespace App\Tests\Action\Authentification;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AuthentificationResponseTest extends WebTestCase
{
    /**
     * @dataProvider provideUrls
     */
    /*public function testTrickResponseIsUp($url)
    {
        $client = static::createClient([], [
        'PHP_AUTH_USER' => 'User1@mail.com',
        'PHP_AUTH_PW'   => 'Pass1',
        ]);


        $client->request('GET', $url);
        $this->assertTrue($client->getResponse()->isSuccessful());
    }

    //url without slugs
    public function provideUrls()
    {
        return[
            ['/login'],
            ['/compte'],
        ];

    }*/
}