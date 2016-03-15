<?php

namespace OpenClassrooms\Bundle\OneSkyBundle\Services;

use OpenClassrooms\Bundle\OneSkyBundle\Model\ExportFile;
use OpenClassrooms\Bundle\OneSkyBundle\Model\UploadFile;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
interface FileService
{
    /**
     * @param ExportFile[] $files
     */
    public function download(array $files);

    /**
     * @param UploadFile[] $files
     */
    public function upload(array $files);
}
