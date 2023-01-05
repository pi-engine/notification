<?php

namespace Notification\Factory\Sender\SMS;

use Interop\Container\Containerinterface;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Notification\Sender\SMS\PayamakYab;

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