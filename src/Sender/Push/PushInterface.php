<?php

namespace Notification\Sender\SMS;

interface PushInterface
{
    public function send($params): int;
}