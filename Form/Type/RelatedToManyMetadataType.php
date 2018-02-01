<?php

/**
 * @author:  Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @license: MIT
 */

namespace IDCI\Bundle\SimpleMetadataBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type as Types;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RelatedToManyMetadataType extends AbstractType
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
    public function getParent()
    {
        return Types\CollectionType::class;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setDefaults(array(
                'entry_type' => RelatedToOneMetadataType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'cascade_validation' => true,
                'attr' => array(
                    'class' => 'idci_metadata__related_to_many_metadata',
                    'data-namespace' => $this->namespace,
                ),
            ))
            ->setNormalizer('options', function (Options $options, $value) {
                if (null === $value) {
                    $value = array();
                }

                return array_merge($value, array(
                    'required' => false,
                    'namespace' => $this->namespace,
                ));
            })
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
        if ($this->namespace) {
            return sprintf('related_to_many_metadata_%s', $this->namespace);
        }

        return 'related_to_many_metadata';
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
