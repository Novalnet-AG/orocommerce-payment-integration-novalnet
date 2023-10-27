<?php

namespace Novalnet\Bundle\NovalnetBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * Class NovalnetExtension
 * @package Novalnet\Bundle\NovalnetBundle\DependencyInjection
 */
class NovalnetExtension extends Extension
{
    const ALIAS = 'novalnet';

    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.yml');
        $loader->load('method.yml');
        $loader->load('callbacks.yml');
        $loader->load('form_types.yml');
        $loader->load('controllers.yml');
    }

    /**
     * {@inheritDoc}
     */
    public function getAlias()
    {
        return self::ALIAS;
    }
}
