<?php

namespace Notification\Factory\Service;

use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Notification\Sender\Mail\MailInterface;
use Notification\Sender\Push\PushInterface;
use Notification\Sender\SMS\SMSInterface;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Notification\Repository\NotificationRepositoryInterface;
use Notification\Service\NotificationService;

class NotificationServiceFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string             $requestedName
     * @param null|array         $options
     *
     * @return NotificationService
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null): NotificationService
    {
        // Get config
        $config = $container->get('config');

        return new NotificationService(
            $container->get(NotificationRepositoryInterface::class),
            $container->get(MailInterface::class),
            $container->get(SMSInterface::class),
            $container->get(PushInterface::class),
            $config['notification']
        );
    }
}