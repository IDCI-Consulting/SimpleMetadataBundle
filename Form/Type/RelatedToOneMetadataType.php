<?php

/**
 * 
 * @author:  Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @license: GPL
 *
 */

namespace IDCI\Bundle\SimpleMetadataBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use IDCI\Bundle\SimpleMetadataBundle\Metadata\MetadataManager;
use IDCI\Bundle\SimpleMetadataBundle\Form\MetadataType;

class RelatedToOneMetadataType extends MetadataType
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
        parent::setDefaultOptions($resolver);
        $resolver->setDefaults(array(
            'cascade_validation' => true,
            'attr' => array(
                'class' => 'idci_metadata__related_to_one_metadata',
                'data-namespace' => $this->namespace
            )
        ));

        if ($this->namespace) {
            $resolver->setDefaults(array('namespace' => $this->namespace));
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        if ($this->namespace) {
            return sprintf('related_to_one_metadata_%s', $this->namespace);
        }

        return 'related_to_one_metadata';
    }
}
