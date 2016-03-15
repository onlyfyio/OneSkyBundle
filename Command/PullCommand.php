<?php

namespace OpenClassrooms\Bundle\OneSkyBundle\Command;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
class PullCommand extends Command
{
    const COMMAND_NAME = 'openclassrooms:one-sky:pull';

    const COMMAND_DESCRIPTION = 'Pull translations';

    /**
     * @return string
     */
    protected function getCommandName()
    {
        return self::COMMAND_NAME;
    }

    protected function getCommandDescription()
    {
        return self::COMMAND_DESCRIPTION;
    }

    protected function process($filePath)
    {
        $this->getContainer()->get('openclassrooms.one_sky.services.translation_service')->pull([$filePath]);
    }
}
