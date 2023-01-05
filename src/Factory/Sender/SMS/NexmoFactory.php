<?php

namespace Notification\Factory\Sender\SMS;

use Interop\Container\Containerinterface;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Notification\Sender\SMS\Nexmo;

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