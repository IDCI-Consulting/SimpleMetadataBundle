<?php

/**
 * @author:  Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @license: MIT
 */

namespace IDCI\Bundle\SimpleMetadataBundle\Metadata;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Event\LifecycleEventArgs;
use IDCI\Bundle\SimpleMetadataBundle\Entity\Metadata;

class MetadataSubscriber implements EventSubscriber
{
    protected $metadatableManager;

    /**
     * Constructor.
     *
     * @param MetadatableManager $metadatableManager
     */
    public function __construct(MetadatableManager $metadatableManager)
    {
        $this->metadatableManager = $metadatableManager;
    }

    /**
     * Get MetadatableManager.
     *
     * @return MetadatableManager
     */
    protected function getMetadatableManager()
    {
        return $this->metadatableManager;
    }

    /**
     * {@inheritdoc}
     */
    public function getSubscribedEvents()
    {
        return array(
            'postLoad',
            'postPersist',
            'postUpdate',
            'postRemove',
        );
    }

    /**
     * Process metadata.
     *
     * @param MetadatableInterface $entity
     * @param EntityManager        $entityManager
     */
    protected function processMetadata(MetadatableInterface $entity, EntityManager $entityManager)
    {
        if (null === $entity->getMetadatas()) {
            return;
        }

        foreach ($entity->getMetadatas() as $metadata) {
            if ($metadata instanceof Metadata) {
                $metadata
                    ->setHash($this->getMetadatableManager()->generateHash($entity))
                    ->setObjectClassName($this->getMetadatableManager()->getObjectClassName($entity))
                    ->setObjectId($this->getMetadatableManager()->getObjectId($entity))
                    ->setObject($entity)
                ;
                $entityManager->persist($metadata);
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function postLoad(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        if ($entity instanceof MetadatableInterface) {
            if (null === $entity->getMetadatas()) {
                return;
            }

            foreach ($entity->getMetadatas() as $metadata) {
                $metadata->setObject($entity);
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function postPersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        $entityManager = $args->getEntityManager();

        if ($entity instanceof MetadatableInterface) {
            $this->processMetadata($entity, $entityManager);
            $entityManager->flush();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function postUpdate(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        $entityManager = $args->getEntityManager();

        if ($entity instanceof MetadatableInterface) {
            $this->processMetadata($entity, $entityManager);

            $uow = $entityManager->getUnitOfWork();
            foreach ($uow->getScheduledCollectionUpdates() as $collectionUpdate) {
                foreach ($collectionUpdate->getDeleteDiff() as $metadata) {
                    if ($metadata instanceof Metadata) {
                        $entityManager->remove($metadata);
                    }
                }
            }

            $entityManager->flush();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function postRemove(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        $entityManager = $args->getEntityManager();

        if ($entity instanceof MetadatableInterface) {
            $metadatas = $entityManager
                ->getRepository('IDCISimpleMetadataBundle:Metadata')
                ->findBy(array(
                    'hash' => $this->getMetadatableManager()->generateHash($entity),
                ))
            ;

            foreach ($metadatas as $metadata) {
                $entityManager->remove($metadata);
            }

            $entityManager->flush();
        }
    }
}
