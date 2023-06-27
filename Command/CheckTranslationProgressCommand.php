<?php

namespace OpenClassrooms\Bundle\OneSkyBundle\Command;

use OpenClassrooms\Bundle\OneSkyBundle\Model\Language;
use OpenClassrooms\Bundle\OneSkyBundle\Services\LanguageService;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
class CheckTranslationProgressCommand extends Command
{
    public const COMMAND_NAME = 'openclassrooms:one-sky:check-translation-progress';

    public const COMMAND_DESCRIPTION = 'Check translations progress';

    public function __construct(
        private readonly LanguageService $languageService,
        private readonly EventDispatcherInterface $eventDispatcher
    ) {
        parent::__construct($this->eventDispatcher);
    }

    protected function configure(): void
    {
        $this->setName($this->getCommandName())
            ->setDescription($this->getCommandDescription())
            ->addOption(
                'locale',
                null,
                InputOption::VALUE_OPTIONAL | InputOption::VALUE_IS_ARRAY,
                'Requested locales',
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
        $output->writeln('<info>Check translations progress</info>');
        $languages = $this->languageService->getLanguages($input->getOption('locale'));
        $table = new Table($output);
        $table
            ->setHeaders(['Locale', 'Progression'])
            ->setRows(
                array_map(
                    static function (Language $language) {
                        return [$language->getLocale(), $language->getTranslationProgress()];
                    },
                    $languages
                )
            );
        $table->render();

        foreach ($languages as $language) {
            if (!$language->isFullyTranslated()) {
                return 1;
            }
        }

        return 0;
    }
}
