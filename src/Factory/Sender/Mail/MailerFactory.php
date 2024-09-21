<?php

namespace Notification\Factory\Sender\Mail;

use Psr\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Notification\Sender\Mail\Mailer;

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