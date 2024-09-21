<?php

namespace Notification\Factory\Sender\Mail;

use Psr\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Notification\Sender\Mail\LaminasMail;

class LaminasMailFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string             $requestedName
     * @param null|array         $options
     *
     * @return LaminasMail
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null): LaminasMail
    {
        return new LaminasMail();
    }
}