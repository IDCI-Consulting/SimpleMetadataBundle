<?php

/**
 * @author:  Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @license: MIT
 */

namespace IDCI\Bundle\SimpleMetadataBundle\Form\Type;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use IDCI\Bundle\SimpleMetadataBundle\Form\MetadataType as FormMetadataType;

class RelatedToOneMetadataType extends FormMetadataType
{
    protected $namespace;

    /**
     * Constructor.
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
    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setDefaults(array(
            'attr' => array(
                'class' => 'idci_metadata__related_to_one_metadata',
                'data-namespace' => $this->namespace,
            ),
        ));

        if ($this->namespace) {
            $resolver->setDefaults(array('namespace' => $this->namespace));
        }
    }

    /**
     * {@inheritdoc}
     *
     * @deprecated
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $this->configureOptions($resolver);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'related_to_one_metadata';
    }

    /**
     * {@inheritdoc}
     *
     * @deprecated
     */
    public function getName()
    {
        if ($this->namespace) {
            return sprintf('related_to_one_metadata_%s', $this->namespace);
        }

        return 'related_to_one_metadata';
    }
}
