<?php

/**
 * @author:  Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @license: MIT
 */

namespace IDCI\Bundle\SimpleMetadataBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
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
        ;

        if (!$options['hide_value_field']) {
            $builder->add('value');
        } else {
            $builder->add('value', 'hidden', array(
                'data' => $options['hidden_value_default_data']
            ));
        }
    }

    /**
     * {@inheritdoc}
     *
     * @deprecated
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver
            ->setDefaults(array(
                'data_class'                => 'IDCI\Bundle\SimpleMetadataBundle\Entity\Metadata',
                'hide_value_field'          => false,
                'hidden_value_default_data' => true
            ))
            ->setOptional(array(
                'namespace'
            ))
            ->setAllowedTypes('hide_value_field', array('bool'))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'idci_bundle_simplemetadatabundle_metadatatype';
    }

    /**
     * {@inheritdoc}
     *
     * @deprecated
     */
    public function getName()
    {
        return $this->getBlockPrefix();
    }
}
