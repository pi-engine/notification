<?php

namespace Notification\Service;

use Notification\Repository\NotificationRepositoryInterface;
use Notification\Service\SendService;

class NotificationService implements ServiceInterface
{
    /* @var NotificationRepositoryInterface */
    protected NotificationRepositoryInterface $notificationRepository;

    /* @var SendService */
    protected SendService $sendService;


    /**
     * @param NotificationRepositoryInterface $notificationRepository
     */
    public function __construct(
        NotificationRepositoryInterface $notificationRepository,
        SendService $sendService
    ) {
        $this->notificationRepository = $notificationRepository;
        $this->sendService = $sendService;
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
        $limit  = (int)($params['limit'] ?? 10);
        $page   = (int)($params['page'] ?? 1);
        $order  = $params['order'] ?? ['time_created DESC', 'id DESC'];
        $offset = ($page - 1) * $limit;
        $userId = $account["id"];

        // Set params
        $listParams = [
            'page'   => $page,
            'limit'  => $limit,
            'order'  => $order,
            'offset' => $offset,
            'user_id' => $userId,
        ];

        return $this->notificationRepository->getNotificationList($listParams);
    }
    /**
     * @param $params
     * @param $account
     *
     * @return array
     */
    public function sendNotification($params, $account)
    {

    }
}
