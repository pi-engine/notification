<?php

namespace Notification\Sender\SMS;

interface SMSInterface
{
    public function send($config, $params): void;
}