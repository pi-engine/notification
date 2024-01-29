<?php

namespace Notification\Factory\Repository;

use Interop\Container\ContainerInterface;
use Laminas\Db\Adapter\AdapterInterface;
use Laminas\Hydrator\ReflectionHydrator;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Notification\Model\IdValue\IdValue;
use Notification\Model\Message\Message;
use Notification\Model\Notification\Notification;
use Notification\Model\Storage;
use Notification\Repository\NotificationRepository;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class NotificationRepositoryFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string             $requestedName
     * @param null|array         $options
     *
     * @return NotificationRepository
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null): NotificationRepository
    {
        return new NotificationRepository(
            $container->get(AdapterInterface::class),
            new ReflectionHydrator(),
            new Storage(0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
        );
    }
}