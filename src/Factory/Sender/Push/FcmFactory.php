<?php

namespace Notification\Factory\Sender\Push;

use Psr\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Notification\Sender\Push\Fcm;

class FcmFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string             $requestedName
     * @param null|array         $options
     *
     * @return Fcm
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null): Fcm
    {
        $config = $container->get('config');
        return new Fcm($config['notification']);
    }
}