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
        $rootNode = $treeBuilder->root('byscripts_alert');

        $rootNode
            ->children()
                ->scalarNode('template')
                    ->defaultValue('default')
                    ->beforeNormalization()
                        ->always(function($value){
                            switch($value)
                            {
                                case 'default':
                                    return '@ByscriptsAlert/default.html.twig';
                                default:
                                    return $value;
                            }
                        })
                    ->end()
                ->end()
                ->arrayNode('classes')
                    ->append($this->iconsNode())
                    ->append($this->typesNode())
                ->end()
            ->end();


        // Here you should define the parameters that are allowed to
        // configure your bundle. See the documentation linked above for
        // more information on that topic.

        return $treeBuilder;
    }

    public function iconsNode()
    {
        $builder = new TreeBuilder();

        return $builder
            ->root('icons')
            ->beforeNormalization()
                ->ifString()
                ->then(function($value){
                    switch($value) {
                        case 'glyphicons':
                            return array(
                                'success' => 'glyphicon glyphicon-success',
                                'warning' => 'glyphicon',
                                'error' => 'glyphicon glyphicon-error',
                                'danger' => 'glyphicon glyphicon-danger',
                                'alert' => 'glyphicon glyphicon-error',
                                'info' => 'glyphicon glyphicon-info',
                            );
                        case 'fontawesome':
                            return array();
                        default:
                            return array();
                    }
                })
            ->end();
    }

    public function typesNode()
    {
        $builder = new TreeBuilder();

        return $builder
            ->root('types')
            ->beforeNormalization()
                ->ifString()
                ->then(function($value) {
                    switch($value) {
                        case 'bootstrap2':
                            return array(
                                'default' => 'alert alert-success',
                                'primary' => 'alert alert-success',
                                'secondary' => 'alert alert-info',
                                'success' => 'alert alert-success',
                                'warning' => 'alert',
                                'error' => 'alert alert-error',
                                'danger' => 'alert alert-danger',
                                'alert' => 'alert alert-error',
                                'info' => 'alert alert-info',
                            );
                        case 'foundation5':
                            return array(
                                'default' =>  'alert-box',
                                'primary' =>  'alert-box',
                                'secondary' =>  'alert-box secondary',
                                'success' =>  'alert-box success',
                                'warning' =>  'alert-box warning',
                                'error' =>  'alert-box alert',
                                'danger' =>  'alert-box alert',
                                'alert' =>  'alert-box alert',
                                'info' =>  'alert-box info',
                            );
                        default:
                            return array(
                                'default' => 'alert alert-success',
                                'primary' => 'alert alert-success',
                                'secondary' => 'alert alert-info',
                                'success' => 'alert alert-success',
                                'warning' => 'alert alert-warning',
                                'error' => 'alert alert-danger',
                                'danger' => 'alert alert-danger',
                                'alert' => 'alert alert-danger',
                                'info' => 'alert alert-info',
                            );
                    }
                })
            ->end()
            ->prototype('scalar')
            ->end()
            ;
    }
}
