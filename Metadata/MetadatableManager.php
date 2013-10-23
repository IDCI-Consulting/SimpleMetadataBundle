<?php

/**
 * 
 * @author:  Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @license: GPL
 *
 */

namespace IDCI\Bundle\SimpleMetadataBundle\Metadata;

use IDCI\Bundle\SimpleMetadataBundle\Metadata\MetadatableInterface;

class MetadatableManager
{
    /**
     * Get Object class name
     *
     * @param MetadatableInterface $metadatable
     * @return string
     */
    public function getObjectClassName(MetadatableInterface $metadatable)
    {
        $reflecion = new \ReflectionClass($metadatable);

        return $reflecion->getName();
    }

    /**
     * Get Object id
     *
     * @param MetadatableInterface $metadatable
     * @return string
     */
    public function getObjectId(MetadatableInterface $metadatable)
    {
        return $metadatable->getId();
    }

    /**
     * Generate hash
     *
     * @param MetadatableInterface $metadatable
     * @return string
     */
    public function generateHash(MetadatableInterface $metadatable)
    {
        return md5(sprintf('%s - %s',
            $this->getObjectClassName($metadatable),
            $metadatable->getId()
        ));
    }
}

