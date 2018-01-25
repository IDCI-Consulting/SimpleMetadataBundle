<?php

/**
 * @author:  Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @author:  Julien ANDRE <j.andre@trepia.fr>
 * @license: MIT
 */

namespace IDCI\Bundle\SimpleMetadataBundle\Twig;

use IDCI\Bundle\SimpleMetadataBundle\Metadata\MetadataManager;
use IDCI\Bundle\SimpleMetadataBundle\Metadata\MetadatableManager;
use IDCI\Bundle\SimpleMetadataBundle\Metadata\MetadatableInterface;

class MetadataExtension extends \Twig_Extension
{
    protected $metadataManager;
    protected $metadatableManager;

    /**
     * Constructor.
     *
     * @param MetadataManager $metadataManager
     */
    public function __construct(MetadataManager $metadataManager, MetadatableManager $metadatableManager)
    {
        $this->metadataManager = $metadataManager;
        $this->metadatableManager = $metadatableManager;
    }

    /**
     * Returns Metadata object manager.
     *
     * @return MetadataManager
     */
    public function getMetadataManager()
    {
        return $this->metadataManager;
    }

    /**
     * Returns Metadatable object manager.
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
     * Returns mtadata value.
     *
     * @param MetadatableInterface $object
     * @param string               $namespace
     * @param string               $key
     *
     * @return string|null The metadata value
     */
    public function metadata(MetadatableInterface $object, $namespace, $key)
    {
        return $this->getMetadataManager()->getValue($object, $namespace, $key);
    }
}
