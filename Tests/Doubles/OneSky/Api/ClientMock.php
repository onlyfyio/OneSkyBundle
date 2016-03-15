<?php

namespace OpenClassrooms\Bundle\OneSkyBundle\Tests\Doubles\OneSky\Api;

use Onesky\Api\Client;
use OpenClassrooms\Bundle\OneSkyBundle\Gateways\FileGateway;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
class ClientMock extends Client
{
    /**
     * @var string
     */
    public static $action;

    /**
     * @var int
     */
    public static $downloadedCount = 0;

    /**
     * @var array
     */
    public static $parameters = [];

    public function __construct()
    {
        parent::__construct();
        self::$action = null;
        self::$downloadedCount = 0;
        self::$parameters = [];
    }

    /**
     * @return string
     */
    public function files($action, $parameters)
    {
        self::$action = $action;
        self::$parameters[] = $parameters;
        if (FileGateway::DOWNLOAD_METHOD === $action) {
            return 'Download : '.++self::$downloadedCount;
        }

        return true;
    }
}
