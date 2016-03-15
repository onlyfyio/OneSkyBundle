<?php

namespace OpenClassrooms\Bundle\OneSkyBundle\Services\Impl;

use OpenClassrooms\Bundle\OneSkyBundle\Model\FileFactory;
use OpenClassrooms\Bundle\OneSkyBundle\Services\FileService;
use OpenClassrooms\Bundle\OneSkyBundle\Services\TranslationService;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
class TranslationServiceImpl implements TranslationService
{
    /**
     * @var FileFactory
     */
    private $fileFactory;

    /**
     * @var string
     */
    private $fileFormat;

    /**
     * @var FileService
     */
    private $fileService;

    /**
     * @var string[]
     */
    private $locales;

    /**
     * @var string
     */
    private $sourceLocale;

    /**
     * {@inheritdoc}
     */
    public function update(array $filePaths, array $locales = [])
    {
        $this->pull($filePaths, $locales);
        $this->push($filePaths);
    }

    /**
     * {@inheritdoc}
     */
    public function pull(array $filePaths, array $locales = [])
    {
        $files = Finder::create()->files()->in($filePaths)->name('*.'.$this->sourceLocale.'.'.$this->fileFormat);
        $exportFiles = [];
        $locales = empty($locales) ? $this->locales : $locales;
        /** @var SplFileInfo $file */
        foreach ($files as $file) {
            foreach ($locales as $locale) {
                $exportFiles[] = $this->fileFactory->createExportFile($file->getRealpath(), $locale);
            }
        }

        $this->fileService->download($exportFiles);
    }

    /**
     * {@inheritdoc}
     */
    public function push(array $filePaths)
    {
        $files = Finder::create()->files()->in($filePaths)->name('*.'.$this->sourceLocale.'.'.$this->fileFormat);
        $uploadFiles = [];
        /** @var SplFileInfo $file */
        foreach ($files as $file) {
            $uploadFiles[] = $this->fileFactory->createUploadFile($file->getRealpath());
        }

        $this->fileService->upload($uploadFiles);
    }

    public function setFileFactory(FileFactory $fileFactory)
    {
        $this->fileFactory = $fileFactory;
    }

    public function setFileFormat($fileFormat)
    {
        $this->fileFormat = $fileFormat;
    }

    public function setFileService(FileService $fileService)
    {
        $this->fileService = $fileService;
    }

    public function setLocales(array $locales)
    {
        $this->locales = $locales;
    }

    public function setSourceLocale($sourceLocale)
    {
        $this->sourceLocale = $sourceLocale;
    }
}
