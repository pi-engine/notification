<?php

namespace Notification\Factory\Service;

use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Notification\Repository\PlatformRepositoryInterface;
use Notification\Service\PlatformService;

class PlatformServiceFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string             $requestedName
     * @param null|array         $options
     *
     * @return PlatformService
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null): PlatformService
    {
        return new PlatformService(
            $container->get(PlatformRepositoryInterface::class)
        );
    }
}