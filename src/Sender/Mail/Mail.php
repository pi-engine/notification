<?php

namespace Notification\Sender\Mail;
 

class Mail implements MailInterface
{

    public function __construct( )
    {

    }

    public function send($params): int
    {
        return 1;
    }
}