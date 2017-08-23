<?php

/**
 * @author:  Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @license: MIT
 */

namespace IDCI\Bundle\SimpleMetadataBundle\Metadata;

use Doctrine\ORM\EntityManager;

class MetadataManager
{
    protected $metadatableManager;
    protected $entityManager;

    /**
     * Constructor.
     *
     * @param MetadatableManager $metadatableManager
     * @param EntityManager      $entityManager
     */
    public function __construct(MetadatableManager $metadatableManager, EntityManager $entityManager)
    {
        $this->metadatableManager = $metadatableManager;
        $this->entityManager      = $entityManager;
    }

    /**
     * Get MetadatableManager.
     *
     * @return MetadatableManager
     */
    public function getMetadatableManager()
    {
        return $this->metadatableManager;
    }

    /**
     * Get EntityManager.
     *
     * @return EntityManager
     */
    public function getEntityManager()
    {
        return $this->entityManager;
    }

    /**
     * Get Repository.
     *
     * @return \Doctrine\ORM\EntityManager\EntityRepository
     */
    public function getRepository()
    {
        return $this
          ->getEntityManager()
          ->getRepository('IDCISimpleMetadataBundle:Metadata')
        ;
    }

    /**
     * Magic call.
     * Triger to repository methods call.
     */
    public function __call($method, $args)
    {
        return call_user_func_array(array($this->getRepository(), $method), $args);
    }

    /**
     * Get all metadata related to an object.
     *
     * @param  MetadatableInterface $object
     *
     * @return array
     */
    public function getAll(MetadatableInterface $object)
    {
        return $this->findBy(array(
            'hash' => $this->getMetadatableManager()->generateHash($object)
        ));
    }

    /**
     * Get all metadata related to an object and a namespace.
     *
     * @param  MetadatableInterface $object
     * @param  string               $namespace
     *
     * @return array
     */
    public function getNamespaced(MetadatableInterface $object, $namespace)
    {
        return $this->findBy(array(
            'hash'      => $this->getMetadatableManager()->generateHash($object),
            'namespace' => $namespace
        ));
    }

    /**
     * Get metadata related to an object, a namespace and a key.
     *
     * @param  MetadatableInterface $object
     * @param  string               $namespace
     * @param  string               $key
     *
     * @return IDCI\Bundle\SimpleMetadataBundle\Entity\Metadata | null
     */
    public function get(MetadatableInterface $object, $namespace, $key)
    {
        return $this->findOneBy(array(
            'hash'      => $this->getMetadatableManager()->generateHash($object),
            'namespace' => $namespace,
            'key'       => $key,
        ));
    }

    /**
     * Get metadata value related to an object, a namespace and a key.
     *
     * @param  MetadatableInterface $object
     * @param  string               $namespace
     * @param  string               $key
     *
     * @return string | null
     */
    public function getValue(MetadatableInterface $object, $namespace, $key)
    {
        $metadata = $this->get($object, $namespace, $key);
        if (null !== $metadata) {
            return $metadata->getValue();
        }

        return null;
    }
}
