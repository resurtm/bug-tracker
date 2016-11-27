<?php

namespace Tests\AppBundle\Controller;

use AppBundle\Entity\ContactMessage;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * @see \AppBundle\Entity\ContactMessage
 */
class ContactMessageTest extends KernelTestCase
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;

    protected function setUp()
    {
        self::bootKernel();

        $this->em = static::$kernel->getContainer()
            ->get('doctrine')
            ->getManager();
    }

    protected function tearDown()
    {
        parent::tearDown();

        $this->em->close();
        $this->em = null;
    }

    public function testGetId()
    {
        $contactMessage = new ContactMessage();
        $contactMessage->setName('Travis Bickle');
        $contactMessage->setEmail('travis-bickle@yandex.ru');
        $contactMessage->setMessage('Hello!');

        $this->assertNull($contactMessage->getId());

        $this->em->persist($contactMessage);
        $this->em->flush();

        $this->assertNotNull($contactMessage->getId());
    }
}