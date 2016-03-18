<?php

namespace OpenClassrooms\Bundle\OneSkyBundle\Gateways\Impl;

use Onesky\Api\Client;
use OpenClassrooms\Bundle\OneSkyBundle\Gateways\LanguageException;
use OpenClassrooms\Bundle\OneSkyBundle\Gateways\LanguageGateway;
use OpenClassrooms\Bundle\OneSkyBundle\Gateways\LanguageNotFoundException;
use OpenClassrooms\Bundle\OneSkyBundle\Model\Language;
use OpenClassrooms\Bundle\OneSkyBundle\Model\LanguageFactory;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
class LanguageGatewayImpl implements LanguageGateway
{
    /**
     * @var Client
     */
    private $client;

    /**
     * @var LanguageFactory
     */
    private $languageFactory;

    /**
     * @var int
     */
    private $projectId;

    /**
     * @return \OpenClassrooms\Bundle\OneSkyBundle\Model\Language[]
     *
     * @throws LanguageException
     * @throws LanguageNotFoundException
     */
    public function findLanguages(array $locales)
    {
        $jsonResponse = $this->client->projects(self::LANGUAGES_METHOD, ['project_id' => $this->projectId]);
        $response = json_decode($jsonResponse, true);

        $this->checkResponse($response, $jsonResponse);

        $languages = $this->languageFactory->createFromCollection($response['data']);
        $languageLocales = $this->getLanguagesLocales($languages);
        $this->checkExistingLocale($locales, $languageLocales);

        return $languages;
    }

    /**
     * @throws LanguageException
     */
    private function checkResponse($response, $jsonResponse)
    {
        if (200 !== $response['meta']['status']) {
            throw new LanguageException($jsonResponse);
        }
    }

    /**
     * @param Language[] $languages
     *
     * @return string[]
     */
    private function getLanguagesLocales(array $languages)
    {
        $languageLocales = [];
        foreach ($languages as $language) {
            $languageLocales[] = $language->getLocale();
        }

        return $languageLocales;
    }

    /**
     * @throws LanguageNotFoundException
     */
    private function checkExistingLocale(array $locales, $languageLocales)
    {
        foreach ($locales as $locale) {
            if (!in_array($locale, $languageLocales)) {
                throw new LanguageNotFoundException($locale);
            }
        }
    }

    public function setClient(Client $client)
    {
        $this->client = $client;
    }

    public function setLanguageFactory(LanguageFactory $languageFactory)
    {
        $this->languageFactory = $languageFactory;
    }

    public function setProjectId($projectId)
    {
        $this->projectId = $projectId;
    }
}
