<?php

namespace MMC\User\Component\Doctrine;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use MMC\User\Bundle\LoginBundle\Entity\LoginFormAuthenticator;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class HashPasswordListener implements EventSubscriber
{
    protected $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function getSubscribedEvents()
    {
        return ['prePersist', 'preUpdate'];
    }

    public function preUpdate(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if (!$entity instanceof LoginFormAuthenticator) {
            return;
        }

        $this->encodePassword($entity);

        $em = $args->getEntityManager();
        $meta = $em->getClassMetadata(get_class($entity));
        $em->getUnitOfWork()->recomputeSingleEntityChangeSet($meta, $entity);
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if (!$entity instanceof LoginFormAuthenticator) {
            return;
        }

        $this->encodePassword($entity);
    }

    /**
     * @param User $entity
     */
    private function encodePassword(LoginFormAuthenticator $entity)
    {
        if (!$entity->getPlainPassword()) {
            return;
        }

        $encoded = $this->passwordEncoder->encodePassword(
            $entity,
            $entity->getPlainPassword()
        );

        $entity->setPassword($encoded);
    }
}
