<?php

namespace OpenClassrooms\Bundle\OneSkyBundle\Command;

use OpenClassrooms\Bundle\OneSkyBundle\Services\TranslationService;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
class UpdateCommand extends Command
{
    public const COMMAND_NAME = 'openclassrooms:one-sky:update';

    public const COMMAND_DESCRIPTION = 'Update translations';

    public function __construct(
        private readonly TranslationService $translationService,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setName($this->getCommandName())
            ->setDescription($this->getCommandDescription());
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
        $output->writeln("<info>Updating translations</info>\n");
        $this->handlePullDisplay($output);
        $this->handlePushDisplay($output);
        $this->translationService->update();
    }
}
