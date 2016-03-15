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

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $relativeFilePaths = $this->getRelativeFilePaths();
        $projectDirectory = $this->getProjectDirectory();

        $filePaths = [];

        $progressBar = new ProgressBar($output, count($relativeFilePaths));
        $progressBar->setFormat(OutputInterface::VERBOSITY_DEBUG);

        foreach ($relativeFilePaths as $relativeFilePath) {
            $filePath = realpath($projectDirectory.$relativeFilePath);
            $filePaths[$relativeFilePath] = $filePath;

            $this->process($filePath);

            $progressBar->setMessage($relativeFilePath);
            $progressBar->advance();
        }

        $output->writeln('Files: ');
        foreach ($filePaths as $relativeFilePath => $filePath) {
            $output->writeln($relativeFilePath);
        }
    }

    /**
     * @return string[]
     */
    private function getRelativeFilePaths()
    {
        return $this->getContainer()->getParameter('openclassrooms_one_sky.file_paths');
    }

    /**
     * @return string
     */
    private function getProjectDirectory()
    {
        return $this->getContainer()->getParameter('kernel.root_dir').'/../';
    }

    abstract protected function process($filePath);
}
