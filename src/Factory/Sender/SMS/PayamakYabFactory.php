<?php

namespace Pi\Notification\Factory\Sender\SMS;

use Psr\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Pi\Notification\Sender\SMS\PayamakYab;

class PayamakYabFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string             $requestedName
     * @param null|array         $options
     *
     * @return PayamakYab
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null): PayamakYab
    {
        return new PayamakYab();
    }
}