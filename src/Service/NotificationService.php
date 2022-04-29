<?php

namespace Notification\Service;

use Notification\Repository\NotificationRepositoryInterface;

class NotificationService implements ServiceInterface
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

    /**
     * @param $params
     * @param $account
     *
     * @return array
     */
    public function getNotificationList($params, $account)
    {
        // Get notifications list
        return $this->notificationRepository->getNotificationList($params,$account);
    }
    /**
     * @param $params
     * @param $account
     *
     * @return array
     */
    public function sendNotification($params, $account)
    {
        // Get notifications list
        return $this->notificationRepository->sendNotification($params,$account);
    }
}
