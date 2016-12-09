<?php

namespace AppBundle\EventListener;

use AppBundle\Entity\Ticket;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class TicketBlameableFixer
{
    /**
     * @var TokenStorageInterface
     */
    private $tokenStorage;

    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

    /**
     * @param LifecycleEventArgs $args
     */
    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        if (!$entity instanceof Ticket) {
            return;
        }

        $user = $this->tokenStorage->getToken()->getUser();

        $entity->setCreatedBy($user);
        $entity->setUpdatedBy($user);
        $entity->setCreatedAt(time());
        $entity->setUpdatedAt(time());
    }

    /**
     * @param LifecycleEventArgs $args
     */
    public function preUpdate(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        if (!$entity instanceof Ticket) {
            return;
        }

        $user = $this->tokenStorage->getToken()->getUser();

        $entity->setUpdatedBy($user);
        $entity->setUpdatedAt(time());
    }
}
