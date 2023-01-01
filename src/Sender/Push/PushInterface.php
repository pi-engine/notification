<?php

namespace Notification\Sender\Push;

interface PushInterface
{
    public function send($params): int;
}