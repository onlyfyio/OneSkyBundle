<?php

namespace OpenClassrooms\Bundle\OneSkyBundle\Tests\Command;

use OpenClassrooms\Bundle\OneSkyBundle\Tests\Doubles\Framework\DependencyInjection\ContainerForTest;
use OpenClassrooms\Bundle\OneSkyBundle\Tests\Doubles\Services\TranslationServiceMock;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
trait CommandTestCase
{
    /**
     * @var string
     */
    public static $filePaths = 'Tests/Fixtures/Resources/translations';

    /**
     * @return ContainerInterface
     */
    protected function getContainer()
    {
        return new ContainerForTest(
            [
                'openclassrooms_one_sky.file_paths' => [self::$filePaths],
                'kernel.root_dir'                   => __DIR__.'/../'
            ],
            ['openclassrooms.one_sky.services.translation_service' => new TranslationServiceMock()]
        );
    }
}
