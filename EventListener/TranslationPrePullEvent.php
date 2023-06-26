<?php

namespace OpenClassrooms\Bundle\OneSkyBundle\EventListener;

use OpenClassrooms\Bundle\OneSkyBundle\Model\ExportFile;
use Symfony\Contracts\EventDispatcher\Event;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
class TranslationPrePullEvent extends Event
{
    public const EVENT_NAME = 'openclassrooms.onesky.event.pre_pull';

    /**
     * @var ExportFile[]
     */
    private $exportFiles;

    /**
     * @param ExportFile[] $exportFiles
     */
    public function __construct(array $exportFiles)
    {
        $this->exportFiles = $exportFiles;
    }

    public static function getEventName(): string
    {
        return self::EVENT_NAME;
    }

    public function getExportFilesCount(): int
    {
        return count($this->exportFiles);
    }
}
