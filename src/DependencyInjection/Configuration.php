<?php

namespace Byscripts\Bundle\AlertBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\Exception\InvalidConfigurationException;

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

        $bootstrap3 = array(
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

        $rootNode
            ->children()
            ->arrayNode('classes')
            ->defaultValue($bootstrap3)
            ->beforeNormalization()
                ->ifString()
                    ->ifNotInArray(['bootstrap2', 'bootstrap3', 'foundation5'])
                    ->thenInvalid('You must choose either bootstrap2, bootstrap3 or foundation5')
                ->always(function($value) use($bootstrap3) {
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
                            case 'bootstrap3':
                                return $bootstrap3;
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
                        }
                    })
                ->end()
                ->prototype('scalar')->end()
            ->end()
            ->scalarNode('template')
                ->defaultValue('default')
            ->end()
        ;

        // Here you should define the parameters that are allowed to
        // configure your bundle. See the documentation linked above for
        // more information on that topic.

        return $treeBuilder;
    }
}
