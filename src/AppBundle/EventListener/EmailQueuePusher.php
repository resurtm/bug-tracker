<?php

namespace AppBundle\EventListener;

use AppBundle\Command\Worker\EmailWorkerCommand;
use AppBundle\Entity\ContactMessage;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Leezy\PheanstalkBundle\Proxy\PheanstalkProxy;
use Symfony\Component\Serializer\Serializer;

class EmailQueuePusher
{
    /**
     * @var PheanstalkProxy
     */
    private $pheanstalk;
    /**
     * @var Serializer
     */
    private $serializer;

    /**
     * @param PheanstalkProxy $pheanstalk
     * @param Serializer $serializer
     */
    public function __construct(PheanstalkProxy $pheanstalk, Serializer $serializer)
    {
        $this->pheanstalk = $pheanstalk;
        $this->serializer = $serializer;
    }

    /**
     * @param LifecycleEventArgs $args
     */
    public function postPersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        if (!$entity instanceof ContactMessage) {
            return;
        }

        //$entityManager = $args->getEntityManager();

        $this->pheanstalk
            ->useTube(EmailWorkerCommand::EMAIL_TUBE)
            ->put($this->serializer->serialize($entity, 'json'));
    }
}
