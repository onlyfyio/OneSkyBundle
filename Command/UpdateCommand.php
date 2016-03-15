<?php

namespace OpenClassrooms\Bundle\OneSkyBundle\Command;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
class UpdateCommand extends Command
{
    const COMMAND_NAME = 'openclassrooms:one-sky:update';

    const COMMAND_DESCRIPTION = 'Update translations';

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
        $this->getContainer()->get('openclassrooms.one_sky.services.translation_service')->update([$filePath]);
    }
}
