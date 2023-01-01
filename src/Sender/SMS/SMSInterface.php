<?php

namespace Notification\Sender\SMS;

interface SMSInterface
{
    public function send($params): int;
}