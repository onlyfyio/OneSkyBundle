<?php

namespace OpenClassrooms\Bundle\OneSkyBundle\Tests\DependencyInjection;

use OpenClassrooms\Bundle\OneSkyBundle\DependencyInjection\OpenClassroomsOneSkyExtension;
use OpenClassrooms\Bundle\OneSkyBundle\OpenClassroomsOneSkyBundle;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
class OpenClassroomsOneSkyExtensionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function container_compile()
    {
        $container = new ContainerBuilder();
        $extension = new OpenClassroomsOneSkyExtension();
        $container->registerExtension($extension);
        $container->registerExtension(new OpenClassroomsOneSkyExtension());
        $container->loadFromExtension('openclassrooms_one_sky');

        $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../Fixtures/Resources/config'));
        $loader->load('config.yml');

        $bundle = new OpenClassroomsOneSkyBundle();
        $bundle->build($container);

        $container->setParameter('kernel.root_dir', __DIR__.'/../../');
        $container->compile();
        $this->assertTrue($container->isFrozen());
    }
}
