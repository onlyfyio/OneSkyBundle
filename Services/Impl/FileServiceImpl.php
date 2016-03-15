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

    /**
     * @param UploadFile[] $files
     */
    public function upload(array $files)
    {
        $this->fileGateway->upload($files);
    }

    public function download(array $files)
    {
        $this->fileGateway->download($files);
    }

    public function setFileGateway(FileGateway $fileGateway)
    {
        $this->fileGateway = $fileGateway;
    }
}
