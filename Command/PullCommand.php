<?php

namespace OpenClassrooms\Bundle\OneSkyBundle\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
class PullCommand extends Command
{
    const COMMAND_NAME = 'openclassrooms:one-sky:pull';

    const COMMAND_DESCRIPTION = 'Pull translations';

    protected function configure()
    {
        $this->setName($this->getCommandName())
            ->setDescription($this->getCommandDescription())
            ->addOption('filePaths', 'dir', InputOption::VALUE_OPTIONAL | InputOption::VALUE_IS_ARRAY, 'File paths', [])
            ->addOption(
                'locales',
                null,
                InputOption::VALUE_OPTIONAL | InputOption::VALUE_IS_ARRAY,
                'Requested requestedLocales',
                []
            );
    }

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

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->handlePullDisplay($output);
        $this->getContainer()->get('openclassrooms.onesky.services.translation_service')->pull(
            $input->getOption('filePaths'),
            $input->getOption('locales')
        );
    }
}
