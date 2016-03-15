<?php

namespace OpenClassrooms\Bundle\OneSkyBundle\Tests\Doubles\Framework\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
class ContainerForTest implements ContainerInterface
{
    /**
     * @var string[]
     */
    public static $parameters;

    /**
     * @var object[]
     */
    public static $services;

    public function __construct(array $parameters = [], array $services = [])
    {
        self::$parameters = $parameters;
        self::$services = $services;
    }

    /**
     * @inheritDoc
     */
    public function set($id, $service)
    {
        return null;
    }

    /**
     * @inheritDoc
     */
    public function get($id, $invalidBehavior = self::EXCEPTION_ON_INVALID_REFERENCE)
    {
        return self::$services[$id];
    }

    /**
     * @inheritDoc
     */
    public function has($id)
    {
        return null;
    }

    /**
     * @inheritDoc
     */
    public function initialized($id)
    {
        return null;
    }

    /**
     * @inheritDoc
     */
    public function getParameter($name)
    {
        return self::$parameters[$name];
    }

    /**
     * @inheritDoc
     */
    public function hasParameter($name)
    {
        return null;
    }

    /**
     * @inheritDoc
     */
    public function setParameter($name, $value)
    {
        return null;
    }
}
