<?php

namespace OpenClassrooms\Bundle\OneSkyBundle\EventListener;

use Symfony\Component\EventDispatcher\Event;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
class TranslationPushEvent extends Event
{
    const EVENT_NAME = 'openclassrooms.onesky.event.push';

    /**
     * @return string
     */
    public static function getEventName()
    {
        return self::EVENT_NAME;
    }
}
