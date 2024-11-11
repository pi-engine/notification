<?php

namespace Notification\Factory\Service;

use Laminas\ServiceManager\Factory\FactoryInterface;
use Notification\Repository\NotificationRepositoryInterface;
use Notification\Sender\Mail\LaminasMail;
use Notification\Sender\Mail\Mailer;
use Notification\Sender\Push\Apns;
use Notification\Sender\Push\Fcm;
use Notification\Sender\SMS\KaveNegar;
use Notification\Sender\SMS\Nexmo;
use Notification\Sender\SMS\PayamakYab;
use Notification\Sender\SMS\Twilio;
use Notification\Service\NotificationService;
use Pi\Core\Service\UtilityService;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

class NotificationServiceFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string             $requestedName
     * @param null|array         $options
     *
     * @return NotificationService
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null): NotificationService
    {
        // Get config
        $config = $container->get('config');

        return new NotificationService(
            $container->get(NotificationRepositoryInterface::class),
            $container->get(UtilityService::class),
            $container->get(LaminasMail::class),
            $container->get(Mailer::class),
            $container->get(Fcm::class),
            $container->get(Apns::class),
            $container->get(Twilio::class),
            $container->get(Nexmo::class),
            $container->get(PayamakYab::class),
            $container->get(KaveNegar::class),
            $config['notification']
        );
    }
}