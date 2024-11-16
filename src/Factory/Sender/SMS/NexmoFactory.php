<?php

namespace Pi\Notification\Factory\Sender\SMS;

use Laminas\ServiceManager\Factory\FactoryInterface;
use Pi\Notification\Sender\SMS\Nexmo;
use Psr\Container\ContainerInterface;

class NexmoFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string             $requestedName
     * @param null|array         $options
     *
     * @return Nexmo
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null): Nexmo
    {
        return new Nexmo();
    }
}