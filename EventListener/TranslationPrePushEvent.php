<?php

namespace OpenClassrooms\Bundle\OneSkyBundle\EventListener;

use OpenClassrooms\Bundle\OneSkyBundle\Model\UploadFile;
use Symfony\Contracts\EventDispatcher\Event;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
class TranslationPrePushEvent extends Event
{
    public const EVENT_NAME = 'openclassrooms.onesky.event.pre_push';

    /**
     * @var UploadFile[]
     */
    private $uploadFiles;

    /**
     * @param UploadFile[] $uploadFiles
     */
    public function __construct(array $uploadFiles)
    {
        $this->uploadFiles = $uploadFiles;
    }

    public static function getEventName(): string
    {
        return self::EVENT_NAME;
    }

    public function getUploadFilesCount(): int
    {
        return count($this->uploadFiles);
    }
}
