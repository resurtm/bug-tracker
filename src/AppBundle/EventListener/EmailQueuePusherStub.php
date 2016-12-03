<?php

namespace AppBundle\EventListener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Leezy\PheanstalkBundle\Proxy\PheanstalkProxy;
use Symfony\Component\Serializer\Serializer;

class EmailQueuePusherStub
{
    /**
     * @param PheanstalkProxy $pheanstalk
     * @param Serializer $serializer
     */
    public function __construct(PheanstalkProxy $pheanstalk, Serializer $serializer)
    {
    }

    /**
     * @param LifecycleEventArgs $args
     */
    public function postPersist(LifecycleEventArgs $args)
    {
    }
}
