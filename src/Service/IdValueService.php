<?php

namespace Notification\Service;

use Notification\Repository\NotificationRepositoryInterface;

class IdValueService implements ServiceInterface
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
