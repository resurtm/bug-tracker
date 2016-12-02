<?php

namespace AppBundle\EventListener;

use AppBundle\Command\Worker\EmailWorkerCommand;
use AppBundle\Entity\ContactMessage;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Leezy\PheanstalkBundle\Proxy\PheanstalkProxy;

class EmailQueuePusher
{
    /**
     * @var PheanstalkProxy
     */
    private $pheanstalk;

    /**
     * @param PheanstalkProxy $pheanstalk
     */
    public function __construct(PheanstalkProxy $pheanstalk)
    {
        $this->pheanstalk = $pheanstalk;
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
            ->put(serialize($entity));
    }
}
