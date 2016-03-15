<?php

namespace OpenClassrooms\Bundle\OneSkyBundle\Services;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
interface TranslationService
{
    /**
     * @param string[] $filePaths
     * @param string[] $locales
     */
    public function pull(array $filePaths, array $locales = []);

    /**
     * @param string[] $filePaths
     */
    public function push(array $filePaths);

    /**
     * @param string[] $filePaths
     */
    public function update(array $filePaths, array $locales = []);
}
