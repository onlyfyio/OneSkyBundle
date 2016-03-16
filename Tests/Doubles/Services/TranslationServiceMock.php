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

    /**
     * @var string[]
     */
    public static $locales = [];

    public function __construct()
    {
        self::$pulledFilePaths = [];
        self::$pushedFilePaths = [];
        self::$updatedFilePaths = [];
        self::$locales = [];
    }

    /**
     * {@inheritdoc}
     */
    public function pull(array $filePaths, array $locales = [])
    {
        self::$pulledFilePaths[] = $filePaths;
        self::$locales[] = $locales;
    }

    /**
     * {@inheritdoc}
     */
    public function push(array $filePaths)
    {
        self::$pushedFilePaths[] = $filePaths;
    }

    /**
     * {@inheritdoc}
     */
    public function update(array $filePaths, array $locales = [])
    {
        self::$updatedFilePaths[] = $filePaths;
        self::$locales[] = $locales;
    }
}
