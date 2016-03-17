<?php

namespace OpenClassrooms\Bundle\OneSkyBundle\Model;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
interface FileFactory
{
    /**
     * @return ExportFile
     */
    public function createExportFile($sourceFilePath, $requestedLocale);

    /**
     * @return UploadFile
     */
    public function createUploadFile($filePath, $locale = null);
}
