<?php

namespace Notification\Model\Notification;

class Notification
{
    private $id;
    private $sender_id;
    private $receiver_id;
    private $platform_id;
    private $target_id;
    private $type;
    private $status;
    private $message_id;
    private $parent_id;

    public function __construct(
        $sender_id,
        $receiver_id,
        $platform_id,
        $target_id,
        $type,
        $message_id,
        $parent_id,
        $status ,
        $id = null
    )
    {
        $this->sender_id=$sender_id;
        $this->receiver_id=$receiver_id;
        $this->platform_id=$platform_id;
        $this->target_id=$target_id;
        $this->type=$type;
        $this->message_id=$message_id;
        $this->parent_id=$parent_id;
        $this->status =$status;
        $this->id =$id;
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getSenderId(): int
    {
        return $this->sender_id;
    }

    /**
     * @return int
     */
    public function getReceiverId(): int
    {
        return $this->receiver_id;
    }

    /**
     * @return int
     */
    public function getPlatformId(): int
    {
        return $this->platform_id;
    }

    /**
     * @return int
     */
    public function getTargetId(): int
    {
        return $this->target_id;
    }

    /**
     * @return int
     */
    public function getType(): int
    {
        return $this->type;
    }

    /**
     * @return int
     */
    public function getMessageId(): int
    {
        return $this->message_id;
    }

    /**
     * @return int
     */
    public function getStatus(): int
    {
        return $this->status;
    }

    /**
     * @return int
     */
    public function getParentId(): int
    {
        return $this->parent_id;
    }
}