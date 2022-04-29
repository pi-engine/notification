<?php

namespace Notification\Repository;

interface NotificationRepositoryInterface
{
    public function getNotificationList( $params,array $account);
    public function sendNotification( $params,array $account);
}