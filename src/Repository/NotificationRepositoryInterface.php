<?php

namespace Notification\Repository;

interface NotificationRepositoryInterface
{
    public function getNotificationList($params, $account);
    public function store($params, $account);
}