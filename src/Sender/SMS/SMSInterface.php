<?php

namespace Notification\Sender\Mail;

interface SMSInterface
{
    public function send($params): int;
}