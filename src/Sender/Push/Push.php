<?php

namespace Notification\Sender\Push;
 

class Push implements PushInterface
{

    public function __construct( )
    {

    }

    public function send($params): int
    {
        return 1;
    }
}