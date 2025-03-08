<?php

namespace Pi\Notification\Sender\SMS;

use Laminas\Soap\Client as LaminasSoapClient;

class PayamakYab implements SMSInterface
{
    public function send($config, $params): void
    {
        // Set SMS params
        $smsParams = [
            'username' => $config['payamakyab']['username'],
            'password' => $config['payamakyab']['password'],
            'from'     => $config['payamakyab']['number'],
            'to'       => [str_replace('+98', '', $params['mobile'])],
            'text'     => $params['message'],
            'isflash'  => false,
            'udh'      => '',
            'recId'    => [0],
            'status'   => [0],
        ];

        // Send SMS
        $client = new LaminasSoapClient($config['payamakyab']['url']);
        $client->SendSms($smsParams)->SendSmsResult;
    }
}