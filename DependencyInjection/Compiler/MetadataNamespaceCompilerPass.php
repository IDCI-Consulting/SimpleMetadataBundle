<?php

/**
 * 
 * @author:  Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @license: GPL
 *
 */

namespace IDCI\Bundle\SimpleMetadataBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\DefinitionDecorator;

class MetadataNamespaceCompilerPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        $metadataNamespacesConfig = $container->getParameter('idci_simple_metadata.namespaces');
        foreach ($metadataNamespacesConfig as $metadataNamespaceId) {
            // Related To Many
            $relatedToManyMetadataNamespaceAlias = sprintf(
                'related_to_many_metadata_%s',
                $metadataNamespaceId
            );
            $relatedToManyMetadataNamespaceServiceId = sprintf(
                'form.type.%s',
                $relatedToManyMetadataNamespaceAlias
            );
            $relatedToManyMetadataNamespaceDefinition = new DefinitionDecorator('form.type.related_to_many_metadata');
            $relatedToManyMetadataNamespaceDefinition->replaceArgument(0, $metadataNamespaceId);
            $container->setDefinition(
                $relatedToManyMetadataNamespaceServiceId,
                $relatedToManyMetadataNamespaceDefinition
            );

            // Related to One
            $relatedToOneMetadataNamespaceAlias = sprintf(
                'related_to_one_metadata_%s',
                $metadataNamespaceId
            );
            $relatedToOneMetadataNamespaceServiceId = sprintf(
                'form.type.%s',
                $relatedToOneMetadataNamespaceAlias
            );
            $relatedToOneMetadataNamespaceDefinition = new DefinitionDecorator('form.type.related_to_one_metadata');
            $relatedToOneMetadataNamespaceDefinition->replaceArgument(0, $metadataNamespaceId);
            $container->setDefinition(
                'form.type.'.$relatedToOneMetadataNamespaceServiceId,
                $relatedToOneMetadataNamespaceDefinition
            );

            // Declare untagged 'form.type' directly to the form.extension
            $definition = $container->getDefinition('form.extension');
            $types = (null === $definition->getArgument(1)) ?
                array() :
                $definition->getArgument(1)
            ;
            $types[$relatedToManyMetadataNamespaceAlias] = $relatedToManyMetadataNamespaceServiceId;
            $types[$relatedToOneMetadataNamespaceAlias] = $relatedToOneMetadataNamespaceServiceId;
            $definition->replaceArgument(1, $types);
        }
    }
}
