<?php

namespace Notification\Service;

use Laminas\Mail;
use Laminas\Soap\Client as LaminasSoapClient;
use PHPMailer\PHPMailer\PHPMailer;
use function str_replace;

class SendService implements ServiceInterface
{
    protected string $mailSender = 'phpMailer';

    public function __construct()
    {
    }

    public function sendMail($params)
    {

    }

    public function sendSms($params)
    {

    }

    public function sendPush($params)
    {

    }
}
