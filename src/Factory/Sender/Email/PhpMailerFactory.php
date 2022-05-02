<?php

namespace Notification\Factory\Sender\Email;

use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Notification\Repository\NotificationRepository;
use Notification\Sender\Email\PhpMailer;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class PhpMailerFactory implements FactoryInterface
{

    /**
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param null|array $options
     *
     * @return PhpMailer
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null): PhpMailer
    {
        return new PhpMailer(
        );
    }
}