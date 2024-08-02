<?php

namespace Notification\Sender\Push;

use Pushok\AuthProvider\Token;
use Pushok\Client;
use Pushok\Notification;
use Pushok\Payload;
use Pushok\Payload\Alert;

class Apns implements PushInterface
{

    protected array $config;

    /**
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->config = $config;
    }


    public function send($config, $params): void
    {
        $deviceToken = 'e01f141712d90e5f6af66f7e4da49e32c3552fb16264bbeb8e7acb665d587ce4';

        $authProvider = Token::create([
            'key_id' => $this->config['key_id'],
            'team_id' => $this->config['team_id'],
            'app_bundle_id' =>$this->config['app_bundle_id'],
            'private_key_path' => $this->config['private_key_path'],
            'private_key_secret' => $this->config['private_key_secret'],
        ]);

        $alert = Alert::create()->setTitle('Hello!');
        $alert = $alert->setBody('First push notification');

        $payload = Payload::create()->setAlert($alert)->setPushType('voip');

        $payload->setSound('default');

        $payload->setCustomValue('key', 'value');

        $deviceTokens = [$deviceToken];

        $notifications = [];
        foreach ($deviceTokens as $deviceToken) {
            $notifications[] = new Notification($payload,$deviceToken);
        }

        $client = new Client($authProvider, $production = $this->config['is_production']);
        $client->addNotifications($notifications);
        $responses = $client->push();

    }
}