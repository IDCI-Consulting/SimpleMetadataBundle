<?php

namespace IDCI\Bundle\SimpleMetadataBundle\Twig;

use IDCI\Bundle\SimpleMetadataBundle\Metadata\MetadataManager;
use IDCI\Bundle\SimpleMetadataBundle\Metadata\MetadatableInterface;


/**
 * MetadataExtension
 *
 * @author Julien ANDRE <j.andre@trepia.fr>
 */
class MetadataExtension extends \Twig_Extension
{
    protected $metadataManager;

    /**
     * Constructor
     *
     * @param MetadataManager $metadataManager
     */
    public function __construct(MetadataManager $metadataManager)
    {
        $this->metadataManager = $metadataManager;
    }

    /**
     * Get Metadata Object Manager
     *
     * @return MetadataManager
     */
    public function getMetadataManager()
    {
        return $this->metadataManager;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'idci_metadata_extension';
    }

    /**
     * {@inheritdoc}
     */
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('metadata', array($this, 'metadata')),
        );
    }

    /**
     * metadata value
     *
     * @param  object $object
     * @param  string $namespace
     * @param  string $key
     * @return string The metadata value
     */
    public function metadata(MetadatableInterface $object, $namespace, $key)
    {
        return $this
            ->getMetadataManager()
            ->getEntityManager()
            ->getRepository('IDCISimpleMetadataBundle:Metadata')
            ->findOneBy(array(
                'namespace' => $namespace,
                'key' => $key
            ))
        ;
    }
}