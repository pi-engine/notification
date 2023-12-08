<?php

namespace Notification\Sender\Push;


class Fcm implements PushInterface
{
    public function send($config, $params): void
    {

        $config = $config["fcm"];
        $url = $config["url"];
        $token = $params['device_token'];
        $serverKey = $config["server_key"];

        $title = $params['title'];
        $in_app_title = $params['in_app_title'];
        $body = $params["body"];
        $in_app_body = $params["body"];
        $type = $params["type"];
        $in_app = $params["in_app"];
        $image_url = $params["image_url"];
        $event = $params["event"];

        $aps = array('mutable-content' => 1);
        $payload = array('aps' => $aps);
        $fcm_options = array('image' => $image_url);
        $apns = array('payload' => $payload, 'fcm_options' => $fcm_options);

        $notification = array('title' => $title, "content_available" => true, "mutable_content" => true, 'body' => $body, 'image' => $image_url, 'sound' => 'default', 'badge' => '1');
        $notData = array('click_action' => 'FLUTTER_NOTIFICATION_CLICK', 'type' => $type, 'in_app_body' => $in_app_body, 'in_app' => $in_app, 'in_app_title' => $in_app_title, 'event' => $event, "image_url" => $image_url);
        if(isset($params['custom_information'])){
            $notData['custom_information'] = $params['custom_information'];
        }
        $arrayToSend = array('to' => $token, 'data' => $notData, 'notification' => $notification, 'apns' => $apns, 'priority' => 'high');
        $json = json_encode($arrayToSend);
        $headers = array();
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
}