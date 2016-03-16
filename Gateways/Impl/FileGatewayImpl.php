<?php

namespace OpenClassrooms\Bundle\OneSkyBundle\Gateways\Impl;

use Onesky\Api\Client;
use OpenClassrooms\Bundle\OneSkyBundle\Gateways\FileGateway;
use OpenClassrooms\Bundle\OneSkyBundle\Gateways\InvalidContentException;
use OpenClassrooms\Bundle\OneSkyBundle\Model\ExportFile;
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
     * @var string
     */
    private $fileFormat;

    /**
     * @inheritdoc
     */
    public function download(ExportFile $file)
    {
        $downloadedContent = $this->client->translations(self::DOWNLOAD_METHOD, $file->format());

        if (in_array($this->fileFormat, ['yml', 'yaml'])) {
            if (false === yaml_parse($downloadedContent)) {
                throw new InvalidContentException($downloadedContent);
            }
        }
        file_put_contents($file->getTargetFilePath(), $downloadedContent);
    }

    /**
     * @inheritdoc
     */
    public function upload(UploadFile $file)
    {
        $this->client->files(self::UPLOAD_METHOD, $file->format());
    }

    public function setClient(Client $client)
    {
        $this->client = $client;
    }
}
