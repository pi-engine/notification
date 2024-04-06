<?php

namespace Notification\Sender\Push;


class Fcm implements PushInterface
{
    public function send($config, $params): void
    {
        $config    = $config["fcm"];
        $url       = $config["url"];
        $token     = $params['device_token'];
        $serverKey = $config["server_key"];

        $title        = $params['title'];
        $in_app_title = $params['in_app_title'];
        $body         = $params["body"];
        $in_app_body  = $params["body"];
        $type         = $params["type"];
        $in_app       = $params["in_app"];
        $image_url    = $params["image_url"];
        $event        = $params["event"];

        $aps         = ['mutable-content' => 1];
        $payload     = ['aps' => $aps];
        $fcm_options = ['image' => $image_url];
        $apns        = ['payload' => $payload, 'fcm_options' => $fcm_options];

        $notification = [
            'title'             => $title,
            "content_available" => true,
            "mutable_content"   => true,
            'body'              => $body,
            'image'             => $image_url,
            'sound'             => 'default',
            'badge'             => '1',
        ];
        $notData      = [
            'click_action' => 'FLUTTER_NOTIFICATION_CLICK',
            'type'         => $type,
            'in_app_body'  => $in_app_body,
            'in_app'       => $in_app,
            'in_app_title' => $in_app_title,
            'event'        => $event,
            "image_url"    => $image_url,
        ];
        $has_data   = true;
        if (isset($params['custom_information'])) {
            $notData['custom_information'] = $params['custom_information'];
            if(isset($params['custom_information']['is_only_data'])){
                $has_data = $params['custom_information']['is_only_data'];
            }
        }
        $arrayToSend                    = ['to' => $token, 'data' => $notData, 'apns' => $apns, 'priority' => 'high'];
        if($has_data){
            $arrayToSend['notification']=  $notification;
        }
        $json                           = json_encode($arrayToSend);
        $headers                        = [];
        $headers[]                      = 'Content-Type: application/json';
        $headers[]                      = 'Authorization: key=' . $serverKey;
        $ch                             = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
    }
}