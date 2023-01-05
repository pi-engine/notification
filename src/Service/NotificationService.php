<?php

namespace Notification\Service;

use IntlDateFormatter;
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
        $this->sendService            = $sendService;
    }

    /**
     * @param $params
     *
     * @return array
     */
    public function getNotificationList($params): array
    {
        // Get notifications list
        $limit  = $params['limit'] ?? 25;
        $page   = $params['page'] ?? 1;
        $order  = $params['order'] ?? ['time_create DESC', 'id DESC'];
        $offset = ($page - 1) * $limit;

        // Set params
        $listParams = [
            'page'   => $page,
            'limit'  => $limit,
            'order'  => $order,
            'offset' => $offset,
            'status' => 1,
        ];

        if (isset($params['user_id']) && !empty($params['user_id'])) {
            $listParams['user_id'] = $params['user_id'];
        }

        // Get list
        $list   = [];
        $rowSet = $this->notificationRepository->getNotificationList($listParams);
        foreach ($rowSet as $row) {
            $list[] = $this->canonizeNotification($row);
        }

        // Get count
        $count = $this->notificationRepository->getNotificationCount($listParams);

        return [
            'result' => true,
            'data'   => [
                'list'      => $list,
                'paginator' => [
                    'count' => $count,
                    'limit' => $limit,
                    'page'  => $page,
                ],
            ],
            'error'  => [],
        ];
    }

    /**
     * @param string $parameter
     * @param string $type
     *
     * @return array
     */
    public function getNotification(string $parameter, string $type = 'id'): array
    {
        $notification = $this->notificationRepository->getNotification($parameter, $type);
        return $this->canonizeNotification($notification);
    }

    /**
     * @param $params
     *
     * @return int
     */
    public function getViewedCount($params): int
    {
        // Set params
        $listParams = [
            'user_id' => $params['user_id'],
            'viewed'  => 0,
            'status'  => 1,
        ];

        return $this->notificationRepository->getNotificationCount($listParams);
    }

    /**
     * @param $params
     */
    public function updateView($params): void
    {
        // Set params
        $updateParams = [
            'id'      => $params['id'],
            'user_id' => $params['user_id'],
            'viewed'  => 1,
        ];

        $this->notificationRepository->updateNotification($updateParams);
    }

    /**
     * @param $notification
     *
     * @return array
     */
    public function canonizeNotification($notification): array
    {
        if (empty($notification)) {
            return [];
        }

        if (is_object($notification)) {
            $notification = [
                'id'          => $notification->getId(),
                'user_id'     => $notification->getUserId(),
                'status'      => $notification->getStatus(),
                'viewed'      => $notification->getViewed(),
                'sent'        => $notification->getSent(),
                'time_create' => $notification->getTimeCreate(),
                'time_update' => $notification->getTimeUpdate(),
                'information' => $notification->getInformation(),
            ];
        } else {
            $notification = [
                'id'          => $notification['id'],
                'user_id'     => $notification['user_id'],
                'status'      => $notification['status'],
                'viewed'      => $notification['viewed'],
                'sent'        => $notification['sent'],
                'time_create' => $notification['time_create'],
                'time_update' => $notification['time_update'],
                'information' => $notification['information'],
            ];
        }

        // date formater
        // todo: improve it
        $formatter = new IntlDateFormatter(
            'fa_IR@calendar=persian',
            IntlDateFormatter::SHORT, //date format
            IntlDateFormatter::NONE, //time format
            'Asia/Tehran',
            IntlDateFormatter::TRADITIONAL,
            'yyyy/MM/dd HH:mm:ss'
        );

        $notification['time_create_view'] = $formatter->format($notification['time_create']);
        $notification['time_update_view'] = $formatter->format($notification['time_update']);

        // Set information
        return !empty($notification['information']) ? json_decode($notification['information'], true) : [];
    }

    /**
     * @param $params
     */
    public function send($params): void
    {
        $addParams = [];

        if (isset($params['mail']) && !empty($params['mail'])) {
            $this->sendService->sendMail($params['mail']);
        }

        if (isset($params['sms']) && !empty($params['sms'])) {
            $this->sendService->sendSms($params['sms']);
        }

        if (isset($params['push']) && !empty($params['push'])) {
            $this->sendService->sendPush($params['push']);
        }

        if (isset($params['db']) && (int)$params['db'] === 1) {
            $this->notificationRepository->addNotification($addParams);
        }
    }
}
