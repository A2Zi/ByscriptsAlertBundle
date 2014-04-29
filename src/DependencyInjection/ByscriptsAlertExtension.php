<?php

namespace Byscripts\Bundle\AlertBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Exception\InvalidConfigurationException;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class ByscriptsAlertExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config        = $this->processConfiguration($configuration, $configs);

        switch ($config['template']) {
            case 'default':
                $config['template'] = '@ByscriptsAlert/default.html.twig';
                break;
        }

        $predefinedParameters = array(
            'container' => array(
                'foundation5' => array(
                    'primary'   => 'alert-box',
                    'secondary' => 'alert-box secondary',
                    'success'   => 'alert-box success',
                    'warning'   => 'alert-box warning',
                    'error'     => 'alert-box alert',
                    'danger'    => 'alert-box alert',
                    'alert'     => 'alert-box alert',
                    'info'      => 'alert-box info',
                ),
                'bootstrap3'  => array(
                    'primary'   => 'alert alert-info',
                    'secondary' => 'alert alert-info',
                    'success'   => 'alert alert-success',
                    'warning'   => 'alert alert-warning',
                    'error'     => 'alert alert-danger',
                    'danger'    => 'alert alert-danger',
                    'alert'     => 'alert alert-danger',
                    'info'      => 'alert alert-info',
                ),
                'bootstrap2'  => array(
                    'primary'   => 'alert alert-info',
                    'secondary' => 'alert alert-info',
                    'success'   => 'alert alert-success',
                    'warning'   => 'alert',
                    'error'     => 'alert alert-error',
                    'danger'    => 'alert alert-danger',
                    'alert'     => 'alert alert-error',
                    'info'      => 'alert alert-info',
                ),
            ),
            'icon'      => array(
                'glyphicons'  => array(
                    'success' => 'glyphicon glyphicon-ok-sign',
                    'warning' => 'glyphicon glyphicon-warning-sign',
                    'error'   => 'glyphicon glyphicon-exclamation-sign',
                    'danger'  => 'glyphicon glyphicon-warning-sign',
                    'alert'   => 'glyphicon glyphicon-bell',
                    'info'    => 'glyphicon glyphicon-info-sign',
                ),
                'fontawesome' => array(
                    'success' => 'fa fa-check-circle',
                    'warning' => 'fa fa-exclamation-triangle',
                    'error'   => 'fa fa-exclamation-circle',
                    'danger'  => 'fa fa-exclamation-triangle',
                    'alert'   => 'fa fa-bell',
                    'info'    => 'fa fa-info-circle',
                ),
            )
        );

        foreach ($config['parameters'] as $name => $parameters) {
            if (!empty($parameters['extends'])) {
                if (!array_key_exists($parameters['extends'], $predefinedParameters[$name])) {
                    throw new InvalidConfigurationException(
                        sprintf(
                            'Invalid argument "%s" for byscripts_alert.parameters.container.extends'
                            . "\n"
                            . 'Available arguments: %s',
                            $parameters['extends'],
                            implode(', ', array_keys($predefinedParameters[$name]))
                        )
                    );
                }
                $config['parameters'][$name] = array_merge(
                    $predefinedParameters[$name][$parameters['extends']],
                    $parameters
                );
                unset($config['parameters'][$name]['extends']);
            }
        }


        $container->setParameter('byscripts_alert.parameters', $config['parameters']);
        $container->setParameter('byscripts_alert.template', $config['template']);

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.xml');
    }
}
