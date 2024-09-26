<?php

namespace OpenClassrooms\Bundle\OneSkyBundle;

use OpenClassrooms\Bundle\OneSkyBundle\DependencyInjection\OpenClassroomsOneSkyExtension;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
class OpenClassroomsOneSkyBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function getContainerExtension(): ?ExtensionInterface
    {
        return new OpenClassroomsOneSkyExtension();
    }
}
