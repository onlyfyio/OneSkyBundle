<?php

namespace OpenClassrooms\Bundle\OneSkyBundle\Command;

use OpenClassrooms\Bundle\OneSkyBundle\EventListener\TranslationDownloadTranslationEvent;
use OpenClassrooms\Bundle\OneSkyBundle\EventListener\TranslationPostPullEvent;
use OpenClassrooms\Bundle\OneSkyBundle\EventListener\TranslationPrePullEvent;
use OpenClassrooms\Bundle\OneSkyBundle\Model\ExportFile;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
abstract class Command extends ContainerAwareCommand
{
    /**
     * @var EventDispatcherInterface
     */
    protected $eventDispatcher;

    /**
     * @var ProgressBar
     */
    private $progressBar;

    protected function configure()
    {
        $this->setName($this->getCommandName())->setDescription($this->getCommandDescription());
    }

    /**
     * @return string
     */
    abstract protected function getCommandName();

    /**
     * @return string
     */
    abstract protected function getCommandDescription();

    protected function executePull(InputInterface $input, OutputInterface $output)
    {
        $this->handlePullDisplay($output);
        $this->pull($input->getArgument('filePaths'), $input->getArgument('locales'));

    }

    private function handlePullDisplay(OutputInterface $output)
    {
        $dispatcher = $this->getContainer()->get('openclassrooms.onesky.event_dispatcher');
        $dispatcher->addListener(
            TranslationPrePullEvent::getEventName(),
            function (TranslationPrePullEvent $event) use ($output) {
                $output->writeln('<info>Pulling for project id '.$this->getProjectId().'</info>');
                $this->progressBar = new ProgressBar($output, $event->getExportFilesCount());
                $this->getProgressBar()->start();
            }
        );

        $dispatcher->addListener(
            TranslationDownloadTranslationEvent::getEventName(),
            function (TranslationDownloadTranslationEvent $event) use ($output) {
                $this->getProgressBar()->advance();
                $this->getProgressBar()->setMessage(
                    '<comment>'.$event->getExportFile()->getSourceFilePathRelativeToProject()
                );
            }
        );

        $dispatcher->addListener(
            TranslationPostPullEvent::getEventName(),
            function (TranslationPostPullEvent $event) use ($output) {
                $this->progressBar->finish();
                $output->writeln('<info>'.count($event->getDownloadedFiles()).' files downloaded. </info>');
                $table = new Table($output);
                $table
                    ->setHeaders(['File', 'Locale'])
                    ->setRows(
                        array_map(
                            function (ExportFile $file) {
                                return [$file->getSourceFilePathRelativeToProject(), $file->getRequestedLocale()];
                            },
                            $event->getDownloadedFiles()
                        )
                    );;
                $table->render();
            }
        );
    }

    /**
     * @return string
     */
    protected function getProjectId()
    {
        return $this->getContainer()->getParameter('openclassrooms_onesky.project_id');
    }

    /**
     * @return ProgressBar
     */
    private function getProgressBar()
    {
        return $this->progressBar;
    }

    /**
     * @param string[] $filePaths
     * @param string[] $locales
     */
    private function pull(array $filePaths, array $locales)
    {
        $this->getContainer()->get('openclassrooms.onesky.services.translation_service')->pull($filePaths, $locales);
    }

    protected function executePush(OutputInterface $output)
    {
        $output->writeln('Pushing translations for project id: '.$this->getProjectId());
        $progressBar = $this->createProgressBar($output);

        $filePaths = [];
        $projectDirectory = $this->getProjectDirectory();
        foreach ($this->getRelativeFilePaths() as $relativeFilePath) {
            $filePath = realpath($projectDirectory.$relativeFilePath);
            $filePaths[$relativeFilePath] = $filePath;

            $this->push($filePath);

            $progressBar->setMessage($relativeFilePath);
            $progressBar->advance();
        }

        $output->writeln('Files pushed: ');
        foreach ($filePaths as $relativeFilePath => $filePath) {
            $output->writeln($relativeFilePath);
        }
    }

    /**
     * @return ProgressBar
     */
    protected function createProgressBar(OutputInterface $output)
    {
        $progressBar = new ProgressBar($output, count($this->getRelativeFilePaths()));
        $progressBar->setFormat(OutputInterface::VERBOSITY_DEBUG);

        return $progressBar;
    }

    /**
     * @return string[]
     */
    protected function getRelativeFilePaths()
    {
        return $this->getContainer()->getParameter('openclassrooms_onesky.file_paths');
    }

    /**
     * @return string
     */
    protected function getProjectDirectory()
    {
        return $this->getContainer()->getParameter('kernel.root_dir').'/../';
    }

    private function push($filePath)
    {
        $this->getContainer()->get('openclassrooms.onesky.services.translation_service')->push([$filePath]);
    }
}
