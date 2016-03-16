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
     * @var string[]
     */
    public static $locales = ['fr'];

    /**
     * @var int
     */
    public static $projectId = 1;

    /**
     * @return ContainerInterface
     */
    protected function getContainer()
    {
        return new ContainerForTest(
            [
                'openclassrooms_one_sky.file_paths' => [self::$filePaths],
                'openclassrooms_one_sky.locales'    => self::$locales,
                'openclassrooms_one_sky.project_id' => self::$projectId,
                'kernel.root_dir'                   => __DIR__.'/../',
            ],
            ['openclassrooms.one_sky.services.translation_service' => new TranslationServiceMock()]
        );
    }
}
