<?php

/**
 * 
 * @author:  Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @license: GPL
 *
 */

namespace IDCI\Bundle\SimpleMetadataBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use IDCI\Bundle\SimpleMetadataBundle\Form\MetadataType;

class RelatedToManyMetadataType extends AbstractType
{
    protected $namespace;

    /**
     * Constructor
     *
     * @param string $namespace
     */
    public function __construct($namespace = null)
    {
        $this->namespace = $namespace;
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'type' => 'related_to_one_metadata',
            'options' => array(
                'required' => false,
                'namespace' => $this->namespace
            ),
            'allow_add' => true,
            'allow_delete' => true,
            'by_reference' => false,
            'cascade_validation' => true,
            'attr' => array(
                'class' => 'idci_metadata__related_to_many_metadata',
                'data-namespace' => $this->namespace
            )
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return 'collection';
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        if ($this->namespace) {
            return sprintf('related_to_many_metadata_%s', $this->namespace);
        }

        return 'related_to_many_metadata';
    }
}
