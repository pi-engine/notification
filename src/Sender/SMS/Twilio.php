<?php

namespace Pi\Notification\Sender\SMS;

use Twilio\Exceptions\ConfigurationException;
use Twilio\Exceptions\TwilioException;
use Twilio\Rest\Client;

class Twilio implements SMSInterface
{
    /**
     * @throws ConfigurationException
     * @throws TwilioException
     */
    public function send($config, $params): void
    {
        $client = new Client($config['twilio']['sid'], $config['twilio']['token']);
        $client->messages->create(
            $params['mobile'],
            [
                'from' => $config['twilio']['number'],
                'body' => $params['message'],
            ]
        );
    }
}