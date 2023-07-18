<?php

namespace OpenClassrooms\Bundle\OneSkyBundle\Tests\Command;

use OpenClassrooms\Bundle\OneSkyBundle\Tests\Doubles\Framework\DependencyInjection\ContainerForTest;
use OpenClassrooms\Bundle\OneSkyBundle\Tests\Doubles\Services\LanguageServiceMock;
use OpenClassrooms\Bundle\OneSkyBundle\Tests\Doubles\Services\TranslationServiceMock;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\EventDispatcher\EventDispatcher;

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
        $eventDispatcher = new EventDispatcher();

        return new ContainerForTest(
            [
                'openclassrooms_onesky.file_paths' => [self::$filePaths],
                'openclassrooms_onesky.requestedLocales' => self::$locales,
                'openclassrooms_onesky.project_id' => self::$projectId,
                'kernel.project_dir' => __DIR__.'/../',
            ],
            [
                'openclassrooms.onesky.services.language_service' => new LanguageServiceMock(),
                'openclassrooms.onesky.services.translation_service' => new TranslationServiceMock($eventDispatcher),
                'openclassrooms.onesky.event_dispatcher' => $eventDispatcher,
            ]
        );
    }
}
