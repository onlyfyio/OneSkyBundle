<?php

namespace OpenClassrooms\Bundle\OneSkyBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
abstract class Command extends ContainerAwareCommand
{
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
        $output->writeln('Pulling translations for project id: '.$this->getProjectId());
        $progressBar = $this->createProgressBar($output);

        $filePaths = [];
        $projectDirectory = $this->getProjectDirectory();
        foreach ($this->getRelativeFilePaths() as $relativeFilePath) {
            $filePath = realpath($projectDirectory.$relativeFilePath);
            $filePaths[$relativeFilePath] = $filePath;

            $this->pull($filePath, $input->getArgument('locales'));

            $progressBar->setMessage($relativeFilePath);
            $progressBar->advance();
        }

        $output->writeln('Files pulled: ');
        foreach ($filePaths as $relativeFilePath => $filePath) {
            $output->writeln($relativeFilePath);
        }
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

    private function pull($filePath, array $locales)
    {
        $this->getContainer()->get('openclassrooms.onesky.services.translation_service')->pull([$filePath], $locales);
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

    private function push($filePath)
    {
        $this->getContainer()->get('openclassrooms.onesky.services.translation_service')->push([$filePath]);
    }
}
