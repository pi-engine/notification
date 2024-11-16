<?php

namespace Pi\Notification\Factory\Sender\Mail;

use Laminas\ServiceManager\Factory\FactoryInterface;
use Pi\Notification\Sender\Mail\Mailer;
use Psr\Container\ContainerInterface;

class MailerFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string             $requestedName
     * @param null|array         $options
     *
     * @return Mailer
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null): Mailer
    {
        return new Mailer();
    }
}