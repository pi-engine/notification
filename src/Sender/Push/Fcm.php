<?php

namespace Notification\Sender\Push;


class Fcm implements PushInterface
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
        $config = $config["fcm"];
        $url = $config["url"];
        $token = $params['device_token'];
        $serverKey = $config["server_key"];

        $title = $this->utility($params['title']);
        $in_app_title = $this->utility($params['in_app_title']);
        $body = $this->utility($params["body"]);
        $in_app_body = $this->utility($params["body"]);
        $type = $params["type"];
        $in_app = $params["in_app"];
        $image_url = $params["image_url"];
        $event = $params["event"];

        $aps = ['mutable-content' => 1];
        $payload = ['aps' => $aps];
        $fcm_options = ['image' => $image_url];
        $apns = ['payload' => $payload, 'fcm_options' => $fcm_options];

        $notification = [
            'title' => $title,
            "content_available" => true,
            "mutable_content" => true,
            'body' => $body,
            'image' => $image_url,
            'sound' => 'default',
            'badge' => '1',
        ];
        $notData = [
            'click_action' => 'FLUTTER_NOTIFICATION_CLICK',
            'type' => $type,
            'in_app_body' => $in_app_body,
            'in_app' => $in_app,
            'in_app_title' => $in_app_title,
            'event' => $event,
            "image_url" => $image_url,
        ];
        $has_data = true;
        if (isset($params['custom_information'])) {
            $notData['custom_information'] = $params['custom_information'];
            ///TODO: decide for this
//            if (isset($params['custom_information']['is_only_data'])) {
//                $has_data = !$params['custom_information']['is_only_data'];
//            }

            if (isset($params['custom_information']['notification_information'])) {
                $notification['title'] = $params['custom_information']['notification_information']['title'];
                $notification['body'] = $params['custom_information']['notification_information']['body'];
                $notData['in_app_title'] = $params['custom_information']['notification_information']['in_app_title'];
                $notData['in_app_body'] = $params['custom_information']['notification_information']['in_app_body'];
            }
        }
        $arrayToSend = ['to' => $token, 'data' => $notData, 'apns' => $apns, 'priority' => 'high'];
        ///TODO: decide for this
       // if ($has_data) {
            $arrayToSend['notification'] = $notification;
       // }
        $json = json_encode($arrayToSend);
        $headers = [];
        $headers[] = 'Content-Type: application/json';
        $headers[] = 'Authorization: key=' . $serverKey;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
    }

    private function utility($text): string
    {
        $limitation = $this->config['push']['setting']['limitation'];
        $xss = $this->config['push']['setting']['xss'];
        $text = $limitation['status'] ? ((strlen($text) > $limitation['length']) ? substr($text, 0, $limitation['length']) . '...' : $text) : $text;
        return $xss['status'] ? htmlspecialchars($text, ENT_QUOTES, 'UTF-8') : $text;
    }
}