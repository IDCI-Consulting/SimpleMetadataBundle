<?php

/**
 * @author:  Brahim BOUKOUFALLAH <brahim.boukoufallah@idci-consulting.fr>
 * @license: MIT
 */

namespace IDCI\Bundle\SimpleMetadataBundle\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use IDCI\Bundle\SimpleMetadataBundle\Entity\Metadata;
use IDCI\Bundle\SimpleMetadataBundle\Metadata\MetadatableInterface;
use IDCI\Bundle\SimpleMetadataBundle\Metadata\MetadatableManager;
use Symfony\Bridge\Doctrine\RegistryInterface;

class MetadataRepository extends ServiceEntityRepository
{
    private $metadatableManager;

    public function __construct(
        RegistryInterface $registry,
        MetadatableManager $metadatableManager
    ) {
        parent::__construct($registry, Metadata::class);

        $this->metadatableManager = $metadatableManager;
    }

    /**
     * Find by metadata query builder.
     *
     * @param QueryBuilder $qb
     * @param string       $join
     * @param array        $metadata
     * @param string       $alias
     * @param string       $operator
     *
     * @return QueryBuilder
     */
    public static function findByMetadataQueryBuilder(
        QueryBuilder $qb,
        $join,
        array $metadata,
        $alias = 'metadata',
        $operator = 'eq'
    ) {
        $qb->join($join, $alias);

        foreach ($metadata as $key => $data) {
            $andX = $qb->expr()->andX();

            foreach ($data as $field => $value) {
                $itemOperator = $operator;

                if (is_array($value)) {
                    $value = $value['value'];
                    $itemOperator = $value['operator'];
                }

                $parameterName = sprintf('%s_%s', $field, $key);
                $andX->add(call_user_func_array(
                    array($qb->expr(), $itemOperator),
                    array(
                        sprintf('%s.%s', $alias, $field),
                        sprintf(':%s', $parameterName),
                    )
                ));

                $qb->setParameter($parameterName, $value);
            }

            $qb->orWhere($andX);
        }

        return $qb;
    }

    /**
     * Find by metadatable.
     *
     * @param MetadatableInterface $metadatable
     *
     * @return array<Metadata>
     */
    public function findByMetadatable(MetadatableInterface $metadatable)
    {
        $objectClassName = $this->metadatableManager->getObjectClassName($metadatable);

        return $this->findBy([
            'objectClassName' => $objectClassName,
            'objectId' => $metadatable->getId(),
        ]);
    }

    /**
     * Get all metadata related to an object.
     *
     * @param MetadatableInterface $object
     *
     * @return array
     */
    public function getAll(MetadatableInterface $object)
    {
        return $this->findBy(array(
            'hash' => $this->metadatableManager->generateHash($object),
        ));
    }

    /**
     * Get all metadata related to an object and a namespace.
     *
     * @param MetadatableInterface $object
     * @param string               $namespace
     *
     * @return array
     */
    public function getNamespaced(MetadatableInterface $object, $namespace)
    {
        return $this->findBy(array(
            'hash' => $this->metadatableManager->generateHash($object),
            'namespace' => $namespace,
        ));
    }

    /**
     * Get metadata related to an object, a namespace and a key.
     *
     * @param MetadatableInterface $object
     * @param string               $namespace
     * @param string               $key
     *
     * @return IDCI\Bundle\SimpleMetadataBundle\Entity\Metadata | null
     */
    public function get(MetadatableInterface $object, $namespace, $key)
    {
        return $this->findOneBy(array(
            'hash' => $this->metadatableManager->generateHash($object),
            'namespace' => $namespace,
            'key' => $key,
        ));
    }

    /**
     * Get metadata value related to an object, a namespace and a key.
     *
     * @param MetadatableInterface $object
     * @param string               $namespace
     * @param string               $key
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
