<?php

namespace Notification\Sender\Mail;

interface MailInterface
{
    public function send($config, $params): void;
}