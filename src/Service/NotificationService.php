<?php

namespace Notification\Service;

use IntlDateFormatter;
use Notification\Repository\NotificationRepositoryInterface;
use Notification\Sender\Mail\MailInterface;
use Notification\Sender\Push\PushInterface;
use Notification\Sender\SMS\SMSInterface;
use User\Service\AccountService;
use function var_dump;

class NotificationService implements ServiceInterface
{
    /* @var NotificationRepositoryInterface */
    protected NotificationRepositoryInterface $notificationRepository;

    /* @var MailInterface */
    protected MailInterface $mailInterface;

    /* @var SMSInterface */
    protected SMSInterface $smsInterface;

    /* @var PushInterface */
    protected PushInterface $pushInterface;

    /* @var array */
    protected array $config;

    /**
     * @param NotificationRepositoryInterface $notificationRepository
     */
    public function __construct(
        NotificationRepositoryInterface $notificationRepository,
        MailInterface                   $mailInterface,
        SMSInterface                    $smsInterface,
        PushInterface                   $pushInterface,
                                        $config
    )
    {
        $this->notificationRepository = $notificationRepository;
        $this->mailInterface = $mailInterface;
        $this->smsInterface = $smsInterface;
        $this->pushInterface = $pushInterface;
        $this->config = $config;
    }

    /**
     * @param $params
     *
     * @return array
     */
    public function getNotificationList($params): array
    {
        // Get notifications list
        $limit = $params['limit'] ?? 25;
        $page = $params['page'] ?? 1;
        $order = $params['order'] ?? ['time_create DESC', 'id DESC'];
        $offset = ($page - 1) * $limit;

        // Set params
        $listParams = [
            'page' => $page,
            'limit' => $limit,
            'order' => $order,
            'offset' => $offset,
            'status' => 1,
        ];

        if (isset($params['user_id']) && !empty($params['user_id'])) {
            $listParams['user_id'] = $params['user_id'];
        }

        // Get list
        $list = [];
        $rowSet = $this->notificationRepository->getNotificationList($listParams);
        foreach ($rowSet as $row) {
            $list[] = $this->canonizeNotification($row);
        }

        // Get count
        $count = $this->notificationRepository->getNotificationCount($listParams);

        return [
            'result' => true,
            'data' => [
                'list' => $list,
                'paginator' => [
                    'count' => $count,
                    'limit' => $limit,
                    'page' => $page,
                ],
            ],
            'error' => [],
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
    public function getNotViewedCount($params): array
    {
        // Set params
        $listParams = [
            'user_id' => $params['user_id'],
            'viewed' => 0,
            'status' => 1,
        ];

        return [
            'result' => true,
            'data' => [
                'count' => $this->notificationRepository->getNotificationCount($listParams),
                'unread' => $this->notificationRepository->getUnreadNotificationCount($listParams),
            ],
            'error' => [],
        ];
    }

    /**
     * @param $params
     */
    public function updateView($params): void
    {
        // Set params
        $updateParams = [
            'id' => $params['id'],
            'user_id' => $params['user_id'],
            'viewed' => 1,
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
                'id' => (int)$notification->getId(),
                'sender_id' => $notification->getSenderId(),
                'receiver_id' => $notification->getReceiverId(),
                'type' => $notification->getType(),
                'status' => $notification->getStatus(),
                'viewed' => $notification->getViewed(),
                'sent' => $notification->getSent(),
                'time_create' => date('Y M d H:i:s', $notification->getTimeCreate()),
                'time_update' => $notification->getTimeUpdate(),
                'information' => $notification->getInformation(),
            ];
        } else {
            $notification = [
                'id' => (int)$notification['id'],
                'sender_id' => 3,
                'receiver_id' => $notification['receiver_id'],
                'type' => $notification['type'],
                'status' => $notification['status'],
                'viewed' => $notification['viewed'],
                'sent' => $notification['sent'],
                'time_create' => date('m/d/Y H:i:s', $notification['time_create']),
                'time_update' => $notification['time_update'],
                'information' => $notification['information'],
            ];
        }

        // Set information
        $information = (!empty($notification['information'])) ? json_decode($notification['information'], true) : [];
        unset($notification['information']);

        return array_merge($notification, $information);
    }

    /**
     * @param $params
     */
    public function send($params, $side = 'customer'): void
    {
        // Send notification as mail
        if (isset($params['email']) && !empty($params['email'])) {
            $this->mailInterface->send($this->config['email'], $params['email']);
        }

        // Send notification as SMS
        if (isset($params['sms']) && !empty($params['sms'])) {
            $this->smsInterface->send($this->config['sms'], $params['sms']);
        }

        // Send notification and push
        if (isset($params['push']) && !empty($params['push'])) {
            $this->pushInterface->send($this->config['push'][$side], $params['push']);
        }

//        var_dump($params);
        // Save to DB

        if (isset($params['information']) && !empty($params['information'])) {
            // Set params
            $addParams = [
                'sender_id' => $params['information']['sender_id'],
                'receiver_id' => $params['information']['receiver_id'],
                'type' => $params['information']['type'],
                'viewed' => 0,
                'sent' => 1,
                'time_create' => time(),
                'time_update' => time(),
                'information' => json_encode($params['information']),
            ];
            if (isset($params['information']['viewed'])) {
                $addParams['viewed'] = $params['information']['viewed'];
            }
            // Add notification to DB
            $this->notificationRepository->addNotification($addParams);
        }
    }

    /**
     * @param $params
     */
    public function middleSend($params): array
    {
        $notificationParams = [
            'information' =>
                [
                    "device_token" => '/topics/global',
                    "in_app" => false,
                    "in_app_title" => $params['title'],
                    "title" => $params['title'],
                    "in_app_body" => $params['message'],
                    "body" => $params['message'],
                    "event" => 'global',
                    "user_id" => (int)$params['user_id'],
                    "item_id" => 0,
                    "viewed" => 1,
                    "sender_id" => $params['user_id'],
                    "type" => 'global',
                    "image_url" => '',
                    "receiver_id" => 0
                ],
        ];
        $notificationParams['push'] = $notificationParams['information'];
        $this->send($notificationParams, 'customer');
        return [
            "result" => true,
        ];
    }

    /**
     * @param $params
     */
    public function middleUpdate($params): void
    {
        $this->notificationRepository->updateNotification($params);
    }
}
