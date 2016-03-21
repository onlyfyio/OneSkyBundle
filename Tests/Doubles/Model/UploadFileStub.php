<?php

namespace OpenClassrooms\Bundle\OneSkyBundle\Tests\Doubles\Model;

use OpenClassrooms\Bundle\OneSkyBundle\Model\Impl\UploadFileImpl;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
abstract class UploadFileStub extends UploadFileImpl
{
    const FILE_FORMAT = 'yaml';

    const PROJECT_DIRECTORY = __DIR__.'/../../../';

    const PROJECT_ID = 1;

    const SOURCE_LOCALE = 'en';

    /**
     * @return string
     */
    public function getFormattedFilePath()
    {
        return sys_get_temp_dir().'/'.$this->getEncodedSourceFileName();
    }
}
