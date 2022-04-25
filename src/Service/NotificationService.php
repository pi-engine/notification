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
    public function getList($params, $account)
    {

        // Get account after update
        return $this->notificationRepository->getList($params,$account);
    }
}
