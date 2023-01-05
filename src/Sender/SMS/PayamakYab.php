<?php

namespace Notification\Sender\SMS;

use Laminas\Soap\Client as LaminasSoapClient;

class PayamakYab implements SMSInterface
{
    public function send($config, $params): void
    {
        // Set config
        $config = $config['payamakYab'][$params['source']] ?? $config['payamakYab'];

        // Set SMS params
        $smsParams = [
            'username' => $config['username'],
            'password' => $config['password'],
            'from'     => $config['number'],
            'to'       => [str_replace('+98', '', $params['mobile'])],
            'text'     => $params['message'],
            'isflash'  => false,
            'udh'      => '',
            'recId'    => [0],
            'status'   => [0],
        ];

        // Send SMS
        $client = new LaminasSoapClient($config['url']);
        $client->SendSms($smsParams)->SendSmsResult;
    }
}