<?php

declare(strict_types=1);

namespace Stadline\LinkdataClient\Linkdata\Bridge\Symfony\Bundle\DependencyInjection;

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
        $rootNode = $treeBuilder->root('linkdata_client');
        $rootNode
            ->children()
                ->scalarNode('base_url')
                ->info('Linkdata base url.')
                ->isRequired()
                ->cannotBeEmpty()
                ->end()
                ->scalarNode('entity_namespace')
                ->info('Entity namespace.')
                ->isRequired()
                ->cannotBeEmpty()
                ->defaultValue('Stadline\LinkdataClient\Linkdata\Entity')
                ->end()
                ->integerNode('max_result_per_page')
                ->info('Max result per page.')
                ->defaultValue(30)
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
