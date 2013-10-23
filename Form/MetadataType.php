<?php

/**
 * 
 * @author:  Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @license: GPL
 *
 */

namespace IDCI\Bundle\SimpleMetadataBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class MetadataType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        if (!isset($options['namespace'])) {
            $builder->add('namespace');
        } else {
            $builder->add('namespace', 'hidden', array('data' => $options['namespace']));
        }

        $builder
            ->add('key')
            ->add('value')
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver
            ->setDefaults(array(
                'data_class'  => 'IDCI\Bundle\SimpleMetadataBundle\Entity\Metadata',
                'attr'        => array(
                    'class'   => sprintf('idci_metadata__%s', $this->getName())
                )
            ))
            ->setOptional(array(
                'namespace'
            ))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'idci_bundle_simplemetadatabundle_metadatatype';
    }
}
