<?php

namespace Notification\Sender\SMS;
 

class SMS implements SMSInterface
{

    public function __construct( )
    {

    }

    public function send($params): int
    {
        return 1;
    }
}