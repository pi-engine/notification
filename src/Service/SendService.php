<?php

namespace Notification\Service;

use Notification\Sender\Mail\Mail;
use Notification\Sender\SMS\SMS;
use Notification\Sender\Push\Push;

class SendService implements ServiceInterface
{

    /* @var Mail */
    protected Mail $mail;

    /* @var Push */
    protected Push $push;

    /* @var SMS */
    protected SMS $sms;

    public function __construct(
        Mail $mail,
        push $push,
        SMS  $sms
    )
    {
        $this->mail = $mail;
        $this->push = $push;
        $this->sms = $sms;
    }

    /**
     * @param $params
     * @param $type type of send method
     *
     * @return array
     */
    public function sendNotification($params, $type)
    {
        $result = array();
        $result["platform"] = $type;
        switch ($type) {
            case "mail":
                /// TODO : set target   (device , mailBox , browser , ...)
//                $result["target"] = "mailbox";
                $result["status"] = $this->mail->send($params);
                break;
            default:
                /// TODO : add unknown platform for denied type
                $result["platform"] = 0;
                $result["status"] = 0;
                break;
        }
        return $result;
    }


}
