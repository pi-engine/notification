<?php

namespace Notification\Sender\Email;
 

class PhpMailer implements PhpMailerInterface
{

    public function __construct( )
    {

    }

    public function send($params): int
    {
        return 1;
    }
}