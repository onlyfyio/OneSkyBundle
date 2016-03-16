<?php

namespace OpenClassrooms\Bundle\OneSkyBundle\Gateways;

use OpenClassrooms\Bundle\OneSkyBundle\Model\ExportFile;
use OpenClassrooms\Bundle\OneSkyBundle\Model\UploadFile;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
interface FileGateway
{
    const UPLOAD_METHOD = 'upload';

    const DOWNLOAD_METHOD = 'translations';

    public function download(ExportFile $file);

    public function upload(UploadFile $file);
}
