<?php

namespace OpenClassrooms\Bundle\OneSkyBundle\Gateways\Impl;

use Onesky\Api\Client;
use OpenClassrooms\Bundle\OneSkyBundle\Gateways\FileGateway;
use OpenClassrooms\Bundle\OneSkyBundle\Model\ExportFile;
use OpenClassrooms\Bundle\OneSkyBundle\Model\File;
use OpenClassrooms\Bundle\OneSkyBundle\Model\UploadFile;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
class FileGatewayImpl implements FileGateway
{
    /**
     * @var Client
     */
    private $client;

    /**
     * @param ExportFile[] $files
     */
    public function download(array $files)
    {
        if (!empty($files)) {
            foreach ($files as $file) {
                $downloadedFile = $this->client->translations(self::DOWNLOAD_METHOD, $file->format());
                if (false !== $downloadedFile) {
                    file_put_contents($file->getTargetFilePath(), $downloadedFile);
                }
            }
        }
    }

    /**
     * @param UploadFile[] $files
     */
    public function upload(array $files)
    {
        if (!empty($files)) {
            foreach ($this->formatFilesToUpload($files) as $file) {
                $this->client->files(self::UPLOAD_METHOD, $file);
            }
        }
    }

    /**
     * @param File[] $files
     */
    private function formatFilesToUpload(array $files)
    {
        $formattedFiles = [];
        foreach ($files as $file) {
            $formattedFiles[] = $file->format();
        }

        return $formattedFiles;
    }

    public function setClient(Client $client)
    {
        $this->client = $client;
    }
}
