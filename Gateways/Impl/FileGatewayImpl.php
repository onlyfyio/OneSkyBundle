<?php

namespace OpenClassrooms\Bundle\OneSkyBundle\Gateways\Impl;

use Onesky\Api\Client;
use OpenClassrooms\Bundle\OneSkyBundle\Gateways\FileGateway;
use OpenClassrooms\Bundle\OneSkyBundle\Gateways\InvalidContentException;
use OpenClassrooms\Bundle\OneSkyBundle\Gateways\NonExistingTranslationException;
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
    public function downloadTranslations(array $files)
    {
        $downloadedFiles = [];
        foreach ($files as $file) {
            try {
                $downloadedFiles[] = $this->downloadTranslation($file);
            } catch (NonExistingTranslationException $ne) {

            }
        }

        return $downloadedFiles;
    }

    /**
     * @inheritdoc
     */
    private function downloadTranslation(ExportFile $file)
    {
        $downloadedContent = $this->client->translations(self::DOWNLOAD_METHOD, $file->format());
        $this->checkTranslation($downloadedContent, $file);
        file_put_contents($file->getTargetFilePath(), $downloadedContent);

        return $file;
    }

    /**
     * @throws InvalidContentException
     * @throws NonExistingTranslationException
     */
    private function checkTranslation($downloadedContent, ExportFile $file)
    {
        if (0 === strpos($downloadedContent, '{')) {
            $json = json_decode($downloadedContent, true);
            if (400 === $json['meta']['status']) {
                throw new NonExistingTranslationException($file->getTargetFilePath());
            }
            throw new InvalidContentException($downloadedContent);
        }
    }

    /**
     * @inheritdoc
     */
    public function uploadTranslations(array $files)
    {
        $uploadedFiles = [];
        foreach ($files as $file) {
            $uploadedFiles[] = $this->uploadTranslation($file);
        }

        return $uploadedFiles;
    }

    /**
     * @inheritdoc
     */
    private function uploadTranslation(UploadFile $file)
    {
        $this->client->files(self::UPLOAD_METHOD, $file->format());

        return $file;
    }

    public function setClient(Client $client)
    {
        $this->client = $client;
    }

    public function setFileFormat($fileFormat)
    {
        $this->fileFormat = $fileFormat;
    }
}
