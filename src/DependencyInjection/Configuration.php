<?php

namespace Byscripts\Bundle\AlertBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode    = $treeBuilder->root('byscripts_alert');

        $rootNode
//            ->addDefaultsIfNotSet()
            ->append($this->templatesNode())
            ->append($this->parametersNode());

        return $treeBuilder;
    }

    private function templatesNode()
    {
        $builder = new TreeBuilder();

        return $builder
            ->root('template', 'scalar')
            ->defaultValue('default');
    }

    private function parametersNode()
    {
        $builder = new TreeBuilder();

        return $builder
            ->root('parameters')
                ->addDefaultsIfNotSet()
                ->children()
                    ->arrayNode('container')
                        ->defaultValue(array('extends' => 'bootstrap3'))
                        ->beforeNormalization()
                            ->ifString()
                            ->then(function($value){
                                    return array('extends' => $value);
                                })
                        ->end()
                        ->prototype('scalar')->end()
                    ->end()
                    ->arrayNode('icon')
                        ->defaultValue(array('extends' => 'glyphicons'))
                        ->beforeNormalization()
                            ->ifString()
                            ->then(function($value){
                                    return array('extends' => $value);
                                })
                        ->end()
                        ->prototype('scalar')->end()
                    ->end()


            ->end();
    }
}
