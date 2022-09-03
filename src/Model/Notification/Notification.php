<?php

namespace Notification\Model\Notification;

class Notification
{
    private $id;
    private $sender_id;
    private $receiver_id;
    private $platform;
    private $provider;
    private $target;
    private $type;
    private $status;
    private $message_id;
    private $message;
    private $messageType;
    private $parent_id;

    public function __construct(
        $sender_id,
        $receiver_id,
        $platform,
        $provider,
        $target,
        $type,
        $message_id,
        $parent_id,
        $status,
        $id = null
    )
    {
        $this->sender_id = $sender_id;
        $this->receiver_id = $receiver_id;
        $this->platform = $platform;
        $this->provider = $provider;
        $this->target = $target;
        $this->type = $type;
        $this->message_id = $message_id;
        $this->parent_id = $parent_id;
        $this->status = $status;
        $this->id = $id;
    }

    /**
     * @param mixed|null $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @param mixed $sender_id
     */
    public function setSenderId($sender_id): void
    {
        $this->sender_id = $sender_id;
    }

    /**
     * @param mixed $receiver_id
     */
    public function setReceiverId($receiver_id): void
    {
        $this->receiver_id = $receiver_id;
    }

    /**
     * @param mixed $provider
     */
    public function setProvider($provider): void
    {
        $this->provider = $provider;
    }

    /**
     * @param mixed $type
     */
    public function setType($type): void
    {
        $this->type = $type;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status): void
    {
        $this->status = $status;
    }

    /**
     * @param mixed $message_id
     */
    public function setMessageId($message_id): void
    {
        $this->message_id = $message_id;
    }

    /**
     * @param mixed $parent_id
     */
    public function setParentId($parent_id): void
    {
        $this->parent_id = $parent_id;
    }

    /**
     * @return mixed
     */
    public function getProvider()
    {
        return $this->provider;
    }

    /**
     * @return mixed
     */
    public function getTarget()
    {
        return $this->target;
    }

    /**
     * @return mixed
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @return mixed
     */
    public function getMessageType()
    {
        return $this->messageType;
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
    public function getPlatform(): string
    {
        return $this->platform;
    }


    /// set target object in notification list
    public function setPlatform($value)
    {
        $this->platform = $value;
    }

    /**
     * @return int
     */
    public function getTargetId(): int
    {
        return $this->target;
    }


    /// set target object in notification list
    public function setTarget($value)
    {
        $this->target = $value;
    }


    /**
     * @return int
     */
    public function getType(): int
    {
        return $this->type;
    }

    /// set message type object in notification list
    public function setMessageType($value)
    {
        $this->messageType = $value;
    }

    /**
     * @return int
     */
    public function getMessageId(): int
    {
        return $this->message_id;
    }


    /// set message object in notification list
    public function setMessage($value)
    {
        $this->message = $value;
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