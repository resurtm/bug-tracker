<?php

namespace AppBundle\EventListener;

use AppBundle\Entity\Ticket;
use Cocur\Slugify\SlugifyInterface;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class TicketEventsListener
{
    /**
     * @var TokenStorageInterface
     */
    private $tokenStorage;
    /**
     * @var SlugifyInterface
     */
    private $slugify;

    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

    /**
     * @param SlugifyInterface $slugify
     */
    public function setSlugify(SlugifyInterface $slugify)
    {
        $this->slugify = $slugify;
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
        $entity->setCreatedAt(time());

        $entity->setUpdatedBy($user);
        $entity->setUpdatedAt(time());

        if ($this->slugify) {
            $entity->setSlug($this->slugify->slugify($entity->getTitle()));
        } else {
            $entity->setSlug($entity->getTitle());
        }
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
