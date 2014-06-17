<?php

namespace IDCI\Bundle\SimpleMetadataBundle\Twig;

use IDCI\Bundle\SimpleMetadataBundle\Metadata\MetadataManager;
use IDCI\Bundle\SimpleMetadataBundle\Metadata\MetadatableManager;
use IDCI\Bundle\SimpleMetadataBundle\Metadata\MetadatableInterface;


/**
 * MetadataExtension
 *
 * @author Julien ANDRE <j.andre@trepia.fr>
 */
class MetadataExtension extends \Twig_Extension
{
    protected $metadataManager;
    protected $metadatableManager;

    /**
     * Constructor
     *
     * @param MetadataManager $metadataManager
     */
    public function __construct(MetadataManager $metadataManager, MetadatableManager $metadatableManager)
    {
        $this->metadataManager = $metadataManager;
        $this->metadatableManager = $metadatableManager;
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
     * Get Metadatable Object Manager
     *
     * @return MetadatableManager
     */
    public function getMetadatableManager()
    {
        return $this->metadatableManager;
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
     * @param  MetadatableInterface $object
     * @param  string               $namespace
     * @param  string               $key
     * @return string | null        The metadata value
     */
    public function metadata(MetadatableInterface $object, $namespace, $key)
    {
        return $this->getMetadataManager()->getValue($object, $namespace, $key);
    }
}
