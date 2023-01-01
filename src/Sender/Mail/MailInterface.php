<?php

namespace Notification\Sender\Mail;

interface MailInterface
{
    public function send($params): int;
}