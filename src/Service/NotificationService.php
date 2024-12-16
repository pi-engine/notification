<?php

namespace Pi\Notification\Service;

use Pi\Core\Service\UtilityService;
use Pi\Notification\Repository\NotificationRepositoryInterface;
use Pi\Notification\Sender\Mail\LaminasMail;
use Pi\Notification\Sender\Mail\Mailer;
use Pi\Notification\Sender\Push\Apns;
use Pi\Notification\Sender\Push\Fcm;
use Pi\Notification\Sender\SMS\KaveNegar;
use Pi\Notification\Sender\SMS\Nexmo;
use Pi\Notification\Sender\SMS\PayamakYab;
use Pi\Notification\Sender\SMS\Twilio;

class NotificationService implements ServiceInterface
{
    /* @var NotificationRepositoryInterface */
    protected NotificationRepositoryInterface $notificationRepository;

    /** @var UtilityService */
    protected UtilityService $utilityService;

    /** @var LaminasMail */
    protected LaminasMail $laminasMailSender;

    /** @var Mailer */
    protected Mailer $mailerSender;

    /** @var Fcm */
    protected Fcm $fcmSender;

    /** @var Apns */
    protected Apns $apnsSender;

    /** @var Twilio */
    protected Twilio $twilioSender;

    /** @var Nexmo */
    protected Nexmo $nexmoSender;

    /** @var PayamakYab */
    protected PayamakYab $payamakYabSender;

    /** @var KaveNegar */
    protected KaveNegar $kaveNegarSender;

    /* @var array */
    protected array $config;

    /**
     * @param NotificationRepositoryInterface $notificationRepository
     */
    public function __construct(
        NotificationRepositoryInterface $notificationRepository,
        UtilityService                  $utilityService,
        LaminasMail                     $laminasMailSender,
        Mailer                          $mailerSender,
        Fcm                             $fcmSender,
        Apns                            $apnsSender,
        Twilio                          $twilioSender,
        Nexmo                           $nexmoSender,
        PayamakYab                      $payamakYabSender,
        KaveNegar                       $kaveNegarSender,
                                        $config
    ) {
        $this->notificationRepository = $notificationRepository;
        $this->utilityService         = $utilityService;
        $this->laminasMailSender      = $laminasMailSender;
        $this->mailerSender           = $mailerSender;
        $this->fcmSender              = $fcmSender;
        $this->apnsSender             = $apnsSender;
        $this->twilioSender           = $twilioSender;
        $this->nexmoSender            = $nexmoSender;
        $this->payamakYabSender       = $payamakYabSender;
        $this->kaveNegarSender        = $kaveNegarSender;
        $this->config                 = $config;
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
            'error'  => new \stdClass(),
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
    public function getNotCount($params): array
    {
        return [
            'result' => true,
            'data'   => [
                'count'  => $this->notificationRepository->getNotificationCount(
                    [
                        'user_id' => $params['user_id'],
                        'status'  => 1,
                    ]
                ),
                'unread' => $this->notificationRepository->getUnreadNotificationCount(
                    [
                        'user_id' => $params['user_id'],
                        'status'  => 1,
                    ]
                ),
            ],
            'error'  => [],
        ];
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
                'id'          => (int)$notification->getId(),
                'company_id'  => $notification->getCompanyId(),
                'sender_id'   => $notification->getSenderId(),
                'receiver_id' => $notification->getReceiverId(),
                'type'        => $notification->getType(),
                'status'      => $notification->getStatus(),
                'viewed'      => $notification->getViewed(),
                'time_create' => $notification->getTimeCreate(),
                'time_update' => $notification->getTimeUpdate(),
                'sent'        => $notification->getSent(),
                'information' => $notification->getInformation(),
            ];
        } else {
            $notification = [
                'id'          => (int)$notification['id'],
                'company_id'  => $notification['company_id'],
                'sender_id'   => $notification['sender_id'],
                'receiver_id' => $notification['receiver_id'],
                'type'        => $notification['type'],
                'status'      => $notification['status'],
                'viewed'      => $notification['viewed'],
                'time_create' => $notification['time_create'],
                'time_update' => $notification['time_update'],
                'sent'        => $notification['sent'],
                'information' => $notification['information'],
            ];
        }

        // Set time view
        $notification['time_create_view'] = $this->utilityService->date($notification['time_create']);
        $notification['time_update_view'] = $this->utilityService->date($notification['time_update']);

        // ToDo: Check it for change key or delete
        $notification['time_create'] = date('Y M d H:i:s', $notification['time_create']);

        // Set information
        $information = (!empty($notification['information'])) ? json_decode($notification['information'], true) : [];
        unset($notification['information']);

        return array_merge($notification, $information);
    }

    /**
     * @param $params
     */
    public function send($params, $section = 'customer'): void
    {
        // Set sender
        $emailSender = $params['email_sender'] ?? 'mailer';
        $smsSender   = $params['sms_sender'] ?? 'twilio';
        $pushSender  = $params['push_sender'] ?? 'fcm';

        // Send a mail notification
        if (isset($params['email']) && !empty($params['email'])) {
            $this->sendEmail($emailSender, $params['email']);
        }

        // Send a sms notification
        if (isset($params['sms']) && !empty($params['sms'])) {
            $this->sendSms($smsSender, $params['sms']);
        }

        // Send a push notification
        if (isset($params['push']) && !empty($params['push'])) {
            $this->sendPush($pushSender, $section, $params['push']);
        }

        // Save to DB
        if (isset($params['information']) && !empty($params['information'])) {
            // Set params
            $addParams = [
                'company_id'  => $params['information']['company_id'] ?? 0,
                'sender_id'   => $params['information']['sender_id'] ?? 0,
                'receiver_id' => $params['information']['receiver_id'],
                'type'        => $params['information']['type'],
                'viewed'      => 0,
                'sent'        => 1,
                'time_create' => time(),
                'time_update' => time(),
                'information' => json_encode($params['information'], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT),
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
                    'device_token' => '/topics/global',
                    'in_app'       => false,
                    'in_app_title' => $params['title'],
                    'title'        => $params['title'],
                    'in_app_body'  => $params['message'],
                    'body'         => $params['message'],
                    'event'        => 'global',
                    'user_id'      => (int)$params['user_id'],
                    'item_id'      => 0,
                    'viewed'       => 1,
                    'sender_id'    => $params['user_id'],
                    'type'         => 'global',
                    'image_url'    => '',
                    'receiver_id'  => 0,
                ],
        ];

        $notificationParams['push'] = $notificationParams['information'];
        $this->send($notificationParams, 'customer');

        return [
            'result' => true,
        ];
    }

    /**
     * @param $params
     */
    public function middleUpdate($params): void
    {
        $this->notificationRepository->updateNotification($params);
    }

    protected function sendEmail($emailSender, $emailParams): void
    {
        switch ($emailSender) {
            default:
            case 'mailer':
                $this->mailerSender->send($this->config['email'], $emailParams);
                break;

            case 'laminasMail':
                $this->laminasMailSender->send($this->config['email'], $emailParams);
                break;
        }
    }

    protected function sendSms($smsSender, $smsParams): void
    {
        switch ($smsSender) {
            default:
            case 'twilio':
                $this->twilioSender->send($this->config['sms'], $smsParams);
                break;

            case 'nexmo':
                $this->nexmoSender->send($this->config['sms'], $smsParams);
                break;

            case 'payamakyab':
                $this->payamakYabSender->send($this->config['sms'], $smsParams);
                break;

            case 'kavenegar':
                $this->kaveNegarSender->send($this->config['sms'], $smsParams);
                break;
        }
    }

    protected function sendPush($pushSender, $section, $pushParams): void
    {
        switch ($pushSender) {
            default:
            case 'fcm':
                $this->fcmSender->send($this->config['push'][$section], $pushParams);
                break;

            case 'apns':
                $this->apnsSender->send($this->config['push'][$section], $pushParams);
                break;
        }
    }
}
