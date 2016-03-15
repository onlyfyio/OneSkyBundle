<?php

namespace OpenClassrooms\Bundle\OneSkyBundle\Model;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
abstract class UploadFile extends File
{
    const FILE_FORMAT = 'file_format';

    const SOURCE_LOCALE = 'locale';

    /**
     * @var string
     */
    protected $fileFormat;

    /**
     * @var string
     */
    protected $formattedSourceFilePath;

    /**
     * @var string
     */
    protected $sourceLocale;

    public function __construct($projectId, $sourceFilePath, $projectDirectory, $fileFormat, $sourceLocale)
    {
        parent::__construct($projectId, $sourceFilePath, $projectDirectory);
        $this->formattedSourceFilePath = sys_get_temp_dir().'/'.$this->getEncodedSourceFileName();
        copy($sourceFilePath, $this->formattedSourceFilePath);

        $this->fileFormat = $fileFormat;
        $this->sourceLocale = $sourceLocale;
    }

    /**
     * @return string[]
     */
    public function format()
    {
        return [
            self::PROJECT_ID       => $this->projectId,
            self::SOURCE_FILE_PATH => $this->formattedSourceFilePath,
            self::FILE_FORMAT      => $this->fileFormat,
            self::SOURCE_LOCALE    => $this->sourceLocale,
        ];
    }
}
