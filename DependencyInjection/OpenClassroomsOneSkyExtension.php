<?php

namespace OpenClassrooms\Bundle\OneSkyBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
class OpenClassroomsOneSkyExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config/'));
        $loader->load('services.xml');
        $config = $this->processConfiguration(new Configuration(), $configs);
        $this->processParameters($container, $config);
    }

    private function processParameters(ContainerBuilder $container, array $config)
    {
        $container->setParameter('openclassrooms_one_sky.api_key', $config['api_key']);
        $container->setParameter('openclassrooms_one_sky.api_secret', $config['api_secret']);
        $container->setParameter('openclassrooms_one_sky.project_id', $config['project_id']);
        $container->setParameter('openclassrooms_one_sky.file_format', $config['file_format']);
        $container->setParameter('openclassrooms_one_sky.source_locale', $config['source_locale']);
    }

    /**
     * @return string
     */
    public function getAlias()
    {
        return 'openclassrooms_one_sky';
    }
}
