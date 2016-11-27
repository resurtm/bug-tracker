<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * @see \AppBundle\Controller\DefaultController
 */
class DefaultControllerTest extends WebTestCase
{
    protected function assertAction($url, $selector, $text, $title)
    {
        $client = static::createClient();
        $crawler = $client->request('GET', $url);

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains($text, $crawler->filter($selector)->text());
        $this->assertContains($title, $crawler->filter('title')->text());
    }

    public function testIndexAction()
    {
        $this->assertAction('/', '.container h1', 'Bug Tracker Software', 'Bug Tracker');
    }

    public function testAboutAction()
    {
        $this->assertAction('/about', '.container h1', 'About Us', 'About Us — Bug Tracker');
    }

    public function testContactAction()
    {
        $this->assertAction('/contact', '.container h1', 'Contact Us', 'Contact Us — Bug Tracker');

        $client = static::createClient();

        $crawler = $client->request('GET', '/contact');
        $form = $crawler->selectButton('Send Message')->form();

        $crawler = $client->submit($form);
        $this->assertEquals(3, $crawler->filter('.form-group.has-error')->count());

        $form['contact_message[name]'] = 'John Preston';
        $form['contact_message[email]'] = 'john-preston@gmail.com';
        $form['contact_message[message]'] = 'Hey there!';
        $crawler = $client->submit($form);
        $this->assertEquals(0, $crawler->filter('.form-group.has-error')->count());
    }
}
