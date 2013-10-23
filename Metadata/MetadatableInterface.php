<?php

/**
 * 
 * @author:  Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @license: GPL
 *
 */

namespace IDCI\Bundle\SimpleMetadataBundle\Metadata;

interface MetadatableInterface
{
    /**
     * Get Id
     *
     * @return string
     */
    public function getId();

    /**
     * Get Metadatas
     *
     * @return array<Metadata>
     */
    public function getMetadatas();
}
