<?php

namespace OpenClassrooms\Bundle\OneSkyBundle\Tests\Doubles\Gateways;

use OpenClassrooms\Bundle\OneSkyBundle\Gateways\FileGateway;
use OpenClassrooms\Bundle\OneSkyBundle\Model\ExportFile;
use OpenClassrooms\Bundle\OneSkyBundle\Model\UploadFile;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
class InMemoryFileGateway implements FileGateway
{
    /**
     * @var ExportFile[]
     */
    public static $downloadedFiles = [];

    /**
     * @var UploadFile[]
     */
    public static $uploadedFiles = [];

    public function __construct()
    {
        self::$downloadedFiles = [];
        self::$uploadedFiles = [];
    }

    /**
     * {@inheritdoc}
     */
    public function downloadTranslations(array $files)
    {
        self::$downloadedFiles = $files;
    }

    /**
     * {@inheritdoc}
     */
    public function uploadTranslations(array $files)
    {
        self::$uploadedFiles = $files;
    }
}
