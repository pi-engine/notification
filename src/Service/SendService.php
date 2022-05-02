<?php

namespace Notification\Service;

use Notification\Sender\Email\PhpMailer;

class SendService implements ServiceInterface
{

    /* @var PhpMailer */
    protected PhpMailer $phpMailer;

    public function __construct(
        PhpMailer $phpMailer
    ) {
        $this->phpMailer = $phpMailer;
    }

    public function sendNotification($params)
    {
        return $params;
    }


}
