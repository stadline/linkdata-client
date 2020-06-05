<?php

declare(strict_types=1);

namespace SportTrackingDataSdk\SportTrackingData\Bridge\Symfony\Bundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

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

        /** @var ArrayNodeDefinition $rootNode */
        $rootNode = $treeBuilder->root('sporttrackingdata');

        $rootNode
            ->children()
                ->scalarNode('base_url')
                ->info('SportTrackingData base url.')
                ->isRequired()
                ->cannotBeEmpty()
                ->defaultValue('https://linkdata.geonaute.com')
            ->end()
        ;

        return $treeBuilder;
    }
}
