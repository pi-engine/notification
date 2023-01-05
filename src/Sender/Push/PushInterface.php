<?php

namespace Notification\Sender\Push;

interface PushInterface
{
    public function send($config, $params): void;
}