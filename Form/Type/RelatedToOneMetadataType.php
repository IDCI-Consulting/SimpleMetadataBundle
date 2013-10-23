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
    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        parent::setDefaultOptions($resolver);
        $resolver->setDefaults(array(
            'cascade_validation' => true,
            'attr' => array(
                'class' => sprintf('idci_metadata__%s', $this->getName())
            )
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'related_to_one_metadata';
    }
}
