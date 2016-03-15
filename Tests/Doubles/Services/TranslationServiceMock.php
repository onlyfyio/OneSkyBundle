<?php

namespace OpenClassrooms\Bundle\OneSkyBundle\Tests\Doubles\Services;

use OpenClassrooms\Bundle\OneSkyBundle\Services\TranslationService;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
class TranslationServiceMock implements TranslationService
{
    /**
     * @var string[]
     */
    public static $pulledFilePaths = [];

    /**
     * @var string[]
     */
    public static $pushedFilePaths = [];

    /**
     * @var string[]
     */
    public static $updatedFilePaths = [];

    public function __construct()
    {
        self::$pulledFilePaths = [];
        self::$pushedFilePaths = [];
        self::$updatedFilePaths = [];
    }

    /**
     * @inheritDoc
     */
    public function pull(array $filePaths, array $locales = [])
    {
        self::$pulledFilePaths[] = $filePaths;
    }

    /**
     * @inheritDoc
     */
    public function push(array $filePaths)
    {
        self::$pushedFilePaths[] = $filePaths;
    }

    /**
     * @inheritDoc
     */
    public function update(array $filePaths, array $locales = [])
    {
        self::$updatedFilePaths[] = $filePaths;
    }
}
