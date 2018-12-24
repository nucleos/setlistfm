<?php

declare(strict_types=1);

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core23\SetlistFm\Bridge\Symfony\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

final class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('core23_setlistfm');

        /* @var ArrayNodeDefinition $rootNode */
        // Keep compatibility with symfony/config < 4.2
        if (!\method_exists($treeBuilder, 'getRootNode')) {
            $rootNode = $treeBuilder->root('core23_setlistfm');
        } else {
            $rootNode = $treeBuilder->getRootNode();
        }

        $this->addApiSection($rootNode);
        $this->addHttpClientSection($rootNode);

        return $treeBuilder;
    }

    /**
     * @param ArrayNodeDefinition $node
     */
    private function addApiSection(ArrayNodeDefinition $node): void
    {
        $node
            ->children()
                ->arrayNode('api')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('key')->isRequired()->end()
                        ->scalarNode('endpoint')->defaultValue('https://api.setlist.fm/rest/1.0/')->end()
                    ->end()
                ->end()
            ->end();
    }

    /**
     * @param ArrayNodeDefinition $node
     */
    private function addHttpClientSection(ArrayNodeDefinition $node): void
    {
        $node
            ->children()
                ->arrayNode('http')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('client')->defaultValue('httplug.client.default')->end()
                        ->scalarNode('message_factory')->defaultValue('httplug.message_factory.default')->end()
                    ->end()
                ->end()
            ->end();
    }
}
