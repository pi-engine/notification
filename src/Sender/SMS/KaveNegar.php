<?php

namespace Notification\Sender\SMS;

use Laminas\Soap\Client as LaminasSoapClient;

class KaveNegar implements SMSInterface
{
    public function send($config, $params): void
    {
        // Set config
        $config = $config['kave_negar'];

        // Set SMS params
        $smsParams = [
            'userName' => $config['username'],
            'password' => $config['password'],
            'sender' => $config['number'],
            'receptor' => [str_replace('+98', '0', $params['mobile'])],
            'message' => $params['message'],
            'unixdate' => 0,
            'msgmode' => 1,
            'status' => 1,
        ];

        // Send SMS
        $client = new LaminasSoapClient($config['url']);
        $client->SendSimpleByLoginInfo($smsParams)->status;
    }
}