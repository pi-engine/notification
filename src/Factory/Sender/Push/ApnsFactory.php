<?php

namespace Notification\Factory\Sender\Push;

use Interop\Container\Containerinterface;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Notification\Sender\Push\Apns;

class ApnsFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string             $requestedName
     * @param null|array         $options
     *
     * @return Apns
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null): Apns
    {
        $config = $container->get('config');
        return new Apns($config['notification']['push']['apns']);
    }
}