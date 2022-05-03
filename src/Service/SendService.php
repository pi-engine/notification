<?php

namespace Notification\Service;

use Notification\Sender\Email\PhpMailer;

class SendService implements ServiceInterface
{

    /* @var PhpMailer */
    protected PhpMailer $phpMailer;

    public function __construct(
        PhpMailer $phpMailer
    )
    {
        $this->phpMailer = $phpMailer;
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
        switch ($type) {
            case "email":
                /// TODO : set platform id (phpMailer , FCM , ...)
                $result["platform_id"] = 2;
                /// TODO : set target id (device , mailBox , browser , ...)
                $result["target_id"] = 4;
                $result["status"] = $this->phpMailer->send($params);
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
