<?php

declare(strict_types=1);

namespace SportTrackingDataSdk\SportTrackingData\Bridge\Symfony\Bundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * @todo : re-check this part and usage to remove parameters
 */
class Configuration implements ConfigurationInterface
{
    /**
     * Generates the configuration tree builder.
     *
     * @return \Symfony\Component\Config\Definition\Builder\TreeBuilder The tree builder
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('sporttrackingdata');
        $rootNode
            ->children()
                ->scalarNode('base_url')
                ->info('SportTrackingData base url.')
                ->isRequired()
                ->cannotBeEmpty()
                ->defaultValue('https://linkdata.geonaute.com')
                ->end()
                ->scalarNode('entity_namespace')
                ->info('Entity namespace.')
                ->isRequired()
                ->cannotBeEmpty()
                ->defaultValue('SportTrackingDataSdk\SportTrackingData\Entity')
                ->end()
                ->scalarNode('iri_prefix')
                ->info('Iri prefix.')
                ->isRequired()
                ->cannotBeEmpty()
                ->defaultValue('/v2')
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
