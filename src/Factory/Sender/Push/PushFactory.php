<?php

namespace Notification\Factory\Sender\Push;

use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Notification\Sender\Push\Push;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class PushFactory implements FactoryInterface
{

    /**
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param null|array $options
     *
     * @return Push
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null): Push
    {
        return new Push(
        );
    }
}