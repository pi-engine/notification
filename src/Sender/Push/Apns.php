<?php

namespace Notification\Sender\Push;

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
    }
}