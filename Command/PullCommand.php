<?php

namespace OpenClassrooms\Bundle\OneSkyBundle\Command;

use OpenClassrooms\Bundle\OneSkyBundle\Services\TranslationService;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
class PullCommand extends Command
{
    public const COMMAND_NAME = 'openclassrooms:one-sky:pull';

    public const COMMAND_DESCRIPTION = 'Pull translations';

    public function __construct(
        EventDispatcherInterface $eventDispatcher,
        private readonly TranslationService $translationService
    ) {
        parent::__construct($eventDispatcher);
    }

    protected function configure(): void
    {
        $this->setName($this->getCommandName())
            ->setDescription($this->getCommandDescription())
            ->addOption('filePath', 'dir', InputOption::VALUE_OPTIONAL | InputOption::VALUE_IS_ARRAY, 'File paths', [])
            ->addOption(
                'locale',
                null,
                InputOption::VALUE_OPTIONAL | InputOption::VALUE_IS_ARRAY,
                'Requested requestedLocale',
                []
            );
    }

    protected function getCommandName(): string
    {
        return self::COMMAND_NAME;
    }

    protected function getCommandDescription(): string
    {
        return self::COMMAND_DESCRIPTION;
    }

    protected function execute(InputInterface $input, OutputInterface $output): void
    {
        $this->handlePullDisplay($output);
        $this->translationService->pull(
            $input->getOption('filePath'),
            $input->getOption('locale')
        );
    }
}
