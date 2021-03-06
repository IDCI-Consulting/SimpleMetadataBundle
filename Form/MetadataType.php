<?php

/**
 * @author:  Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @license: MIT
 */

namespace IDCI\Bundle\SimpleMetadataBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type as Types;
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
            $builder->add('namespace', Types\HiddenType::class, array('data' => $options['namespace']));
        }

        $builder
            ->add('key')
        ;

        if (!$options['hide_value_field']) {
            $builder->add('value');
        } else {
            $builder->add('value', Types\HiddenType::class, array(
                'data' => $options['hidden_value_default_data'],
            ));
        }
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setDefaults(array(
                'data_class' => 'IDCI\Bundle\SimpleMetadataBundle\Entity\Metadata',
                'hide_value_field' => false,
                'hidden_value_default_data' => true,
            ))
            ->setDefined('namespace')
            ->setAllowedTypes('hide_value_field', array('bool'))
        ;
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
