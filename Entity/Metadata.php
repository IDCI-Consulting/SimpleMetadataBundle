<?php

/**
 * 
 * @author:  Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @license: GPL
 *
 */

namespace IDCI\Bundle\SimpleMetadataBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use IDCI\Bundle\SimpleMetadataBundle\Metadata\MetadatableInterface;

/**
 * @ORM\Entity
 * @ORM\Table(name="metadata", indexes={
 *     @ORM\Index(name="metadata_search", columns={"namespace", "_key"}),
 *     @ORM\Index(name="metadata_hash", columns={"hash"}),
 *     @ORM\Index(name="metadata_object", columns={"object_class_name", "object_id"})
 * })
 */
class Metadata
{
    /**
     * @var integer
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $namespace;

    /**
     * @var string
     *
     * @ORM\Column(name="_key", type="string", length=255, nullable=false)
     */
    private $key;

    /**
     * @var string
     *
     * @ORM\Column(name="_value", type="string", length=255, nullable=true)
     */
    private $value;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $hash;

    /**
     * @var string
     *
     * @ORM\Column(name="object_class_name", type="string", length=128, nullable=true)
     */
    private $objectClassName;

    /**
     * @var string
     *
     * @ORM\Column(name="object_id", type="string", length=64, nullable=true)
     */
    private $objectId;

    /**
     * @var MetadatableInterface
     */
    private $object;

    /**
     * toString
     *
     * @return string
     */
    public function __toString()
    {
        return sprintf('%s: %s', 
            $this->getKey(),
            $this->getValue()
        );
    }

    /**
     * Get Object
     *
     * @return MetadatableInterface
     */
    public function getObject()
    {
        return $this->object;
    }

    /**
     * Set Object
     *
     * @param MetadatableInterface $object
     * @return Website
     */
    public function setObject(MetadatableInterface $object)
    {
        $this->object = $object;

        return $this;
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }


    /**
     * Set namespace
     *
     * @param string $namespace
     * @return Metadata
     */
    public function setNamespace($namespace)
    {
        $this->namespace = $namespace;
    
        return $this;
    }

    /**
     * Get namespace
     *
     * @return string 
     */
    public function getNamespace()
    {
        return $this->namespace;
    }

    /**
     * Set key
     *
     * @param string $key
     * @return Metadata
     */
    public function setKey($key)
    {
        $this->key = $key;
    
        return $this;
    }

    /**
     * Get key
     *
     * @return string 
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * Set value
     *
     * @param string $value
     * @return Metadata
     */
    public function setValue($value)
    {
        $this->value = $value;
    
        return $this;
    }

    /**
     * Get value
     *
     * @return string 
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set hash
     *
     * @param string $hash
     * @return Metadata
     */
    public function setHash($hash)
    {
        $this->hash = $hash;
    
        return $this;
    }

    /**
     * Get hash
     *
     * @return string 
     */
    public function getHash()
    {
        return $this->hash;
    }

    /**
     * Set objectClassName
     *
     * @param string $objectClassName
     * @return Metadata
     */
    public function setObjectClassName($objectClassName)
    {
        $this->objectClassName = $objectClassName;
    
        return $this;
    }

    /**
     * Get objectClassName
     *
     * @return string 
     */
    public function getObjectClassName()
    {
        return $this->objectClassName;
    }

    /**
     * Set objectId
     *
     * @param string $objectId
     * @return Metadata
     */
    public function setObjectId($objectId)
    {
        $this->objectId = $objectId;
    
        return $this;
    }

    /**
     * Get objectId
     *
     * @return string 
     */
    public function getObjectId()
    {
        return $this->objectId;
    }
}
