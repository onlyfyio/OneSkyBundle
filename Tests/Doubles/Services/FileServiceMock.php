<?php

namespace OpenClassrooms\Bundle\OneSkyBundle\Tests\Doubles\Services;

use OpenClassrooms\Bundle\OneSkyBundle\Model\ExportFile;
use OpenClassrooms\Bundle\OneSkyBundle\Model\UploadFile;
use OpenClassrooms\Bundle\OneSkyBundle\Services\FileService;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
class FileServiceMock implements FileService
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
    public function download(array $files)
    {
        self::$downloadedFiles = $files;

        return self::$downloadedFiles;
    }

    /**
     * {@inheritdoc}
     */
    public function upload(array $files)
    {
        self::$uploadedFiles = $files;

        return self::$uploadedFiles;
    }
}
