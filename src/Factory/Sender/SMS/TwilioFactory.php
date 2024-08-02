<?php

namespace Notification\Factory\Sender\SMS;

use Interop\Container\Containerinterface;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Notification\Sender\SMS\Twilio;

class TwilioFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string             $requestedName
     * @param null|array         $options
     *
     * @return Twilio
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null): Twilio
    {
        return new Twilio();
    }
}