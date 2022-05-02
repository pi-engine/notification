<?php

namespace Notification\Sender\Email;

interface PhpMailerInterface
{
    public function send($params): bool;
}