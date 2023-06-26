<?php

namespace OpenClassrooms\Bundle\OneSkyBundle\Services;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
interface LanguageService
{
    public function getLanguages(array $locales = []): array;
}
