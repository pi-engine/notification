<?php

namespace Notification\Factory\Repository;

use Interop\Container\ContainerInterface;
use Laminas\Db\Adapter\AdapterInterface;
use Laminas\Hydrator\ReflectionHydrator;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Notification\Repository\PlatformRepository;

class PlatformRepositoryFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string             $requestedName
     * @param null|array         $options
     *
     * @return PlatformRepository
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null): PlatformRepository
    {
        return new PlatformRepository(
            $container->get(AdapterInterface::class),
            new ReflectionHydrator()
        );
    }
}