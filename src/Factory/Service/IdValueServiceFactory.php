<?php

namespace Notification\Factory\Service;

use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Notification\Repository\IdValueRepositoryInterface;
use Notification\Service\IdValueService;

class IdValueServiceFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string             $requestedName
     * @param null|array         $options
     *
     * @return IdValueService
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null): IdValueService
    {
        return new IdValueService(
            $container->get(IdValueRepositoryInterface::class)
        );
    }
}