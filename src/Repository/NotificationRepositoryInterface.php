<?php

namespace Notification\Repository;

interface NotificationRepositoryInterface
{
    public function getList( $params,array $account);
}