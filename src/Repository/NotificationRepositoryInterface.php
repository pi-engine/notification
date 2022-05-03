<?php

namespace Notification\Repository;

interface NotificationRepositoryInterface
{
    public function getNotificationList($params);
    public function store($params);
}