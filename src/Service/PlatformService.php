<?php

namespace Notification\Service;

use Notification\Repository\NotificationRepositoryInterface;

class PlatformService implements ServiceInterface
{
    /* @var NotificationRepositoryInterface */
    protected NotificationRepositoryInterface $notificationRepository;


    /**
     * @param NotificationRepositoryInterface $notificationRepository
     */
    public function __construct(
        NotificationRepositoryInterface $notificationRepository
    ) {
        $this->notificationRepository = $notificationRepository;
    }
}
