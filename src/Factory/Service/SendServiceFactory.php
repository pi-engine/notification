<?php

namespace Notification\Factory\Service;

use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Notification\Sender\Mail\Mail;
use Notification\Sender\Push\Push;
use Notification\Sender\SMS\SMS;
use Notification\Service\SendService;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Notification\Service\NotificationService;

class SendServiceFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string             $requestedName
     * @param null|array         $options
     *
     * @return SendService
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null): SendService
    {
        return new SendService(
            $container->get(Mail::class),
            $container->get(Push::class),
            $container->get(SMS::class)
        );
    }
}