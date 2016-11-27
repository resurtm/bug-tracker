<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testContactAction()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/contact');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains('Contact Us', $crawler->filter('.container h1')->text());
    }
}
