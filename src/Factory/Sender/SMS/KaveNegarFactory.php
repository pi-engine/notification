<?php

namespace Notification\Factory\Sender\SMS;

use Interop\Container\Containerinterface;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Notification\Sender\SMS\KaveNegar;

class KaveNegarFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string             $requestedName
     * @param null|array         $options
     *
     * @return  KaveNegar
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null):  KaveNegar
    {
        return new  KaveNegar();
    }
}