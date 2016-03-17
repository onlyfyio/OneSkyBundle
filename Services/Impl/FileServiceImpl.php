<?php

namespace OpenClassrooms\Bundle\OneSkyBundle\Services\Impl;

use OpenClassrooms\Bundle\OneSkyBundle\Gateways\FileGateway;
use OpenClassrooms\Bundle\OneSkyBundle\Model\UploadFile;
use OpenClassrooms\Bundle\OneSkyBundle\Services\FileService;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
class FileServiceImpl implements FileService
{
    /**
     * @var FileGateway
     */
    private $fileGateway;

    public function download(array $files)
    {
        return $this->fileGateway->downloadTranslations($files);
    }

    /**
     * @param UploadFile[] $files
     */
    public function upload(array $files)
    {
        return $this->fileGateway->uploadTranslations($files);
    }

    public function setFileGateway(FileGateway $fileGateway)
    {
        $this->fileGateway = $fileGateway;
    }
}
