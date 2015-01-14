<?php

/**
 * @author:  Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @license: MIT
 */

namespace IDCI\Bundle\SimpleMetadataBundle\Metadata;

interface MetadatableInterface
{
    /**
     * Returns the Id.
     *
     * @return string
     */
    public function getId();

    /**
     * Returns metadatas.
     *
     * @return array<Metadata>
     */
    public function getMetadatas();
}
