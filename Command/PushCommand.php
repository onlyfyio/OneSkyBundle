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
class PushCommand extends Command
{
    public const COMMAND_NAME = 'openclassrooms:one-sky:push';

    public const COMMAND_DESCRIPTION = 'Push translations';

    public function __construct(
        EventDispatcherInterface $eventDispatcher,
        private readonly TranslationService $translationService,
        string $projectId
    ) {
        parent::__construct($eventDispatcher, $projectId);
    }

    protected function configure(): void
    {
        $this->setName($this->getCommandName())
            ->setDescription($this->getCommandDescription())
            ->addOption('filePath', 'dir', InputOption::VALUE_OPTIONAL | InputOption::VALUE_IS_ARRAY, 'File path', [])
            ->addOption(
                'locale',
                null,
                InputOption::VALUE_OPTIONAL | InputOption::VALUE_IS_ARRAY,
                'Source locale',
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

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->handlePushDisplay($output);
        $this->translationService->push(
            $input->getOption('filePath'),
            $input->getOption('locale')
        );

        return 0;
    }
}
