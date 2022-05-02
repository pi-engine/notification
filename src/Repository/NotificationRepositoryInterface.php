<?php

namespace Notification\Repository;

interface NotificationRepositoryInterface
{
    public function getNotificationList($params);
    public function sendNotification( $params,array $account);
}