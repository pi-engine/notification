<?php

namespace Notification\Factory\Service;

use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Notification\Repository\MessageRepositoryInterface;
use Notification\Service\MessageService;

class MessageServiceFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string             $requestedName
     * @param null|array         $options
     *
     * @return MessageService
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null): MessageService
    {
        return new MessageService(
            $container->get(MessageRepositoryInterface::class)
        );
    }
}