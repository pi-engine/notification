<?php

namespace Notification\Model;

class Storage
{
    private mixed $id;
    private int $sender_id;
    private int $receiver_id;
    private string $type;
    private int $status;
    private int $viewed;
    private int $sent;
    private int $time_create;
    private int $time_update;
    private string $information;

    /**
     * @param mixed $id
     * @param int $sender_id
     * @param int $receiver_id
     * @param string $type
     * @param int $status
     * @param int $viewed
     * @param int $sent
     * @param int $time_create
     * @param int $time_update
     * @param string $information
     */
    public function __construct(mixed $id, int $sender_id, int $receiver_id, string $type, int $status, int $viewed, int $sent, int $time_create, int $time_update, string $information)
    {
        $this->id = $id;
        $this->sender_id = $sender_id;
        $this->receiver_id = $receiver_id;
        $this->type = $type;
        $this->status = $status;
        $this->viewed = $viewed;
        $this->sent = $sent;
        $this->time_create = $time_create;
        $this->time_update = $time_update;
        $this->information = $information;
    }

    /**
     * @return mixed
     */
    public function getId(): mixed
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId(mixed $id): void
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getSenderId(): int
    {
        return $this->sender_id;
    }

    /**
     * @param int $sender_id
     */
    public function setSenderId(int $sender_id): void
    {
        $this->sender_id = $sender_id;
    }

    /**
     * @return int
     */
    public function getReceiverId(): int
    {
        return $this->receiver_id;
    }

    /**
     * @param int $receiver_id
     */
    public function setReceiverId(int $receiver_id): void
    {
        $this->receiver_id = $receiver_id;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType(string $type): void
    {
        $this->type = $type;
    }

    /**
     * @return int
     */
    public function getStatus(): int
    {
        return $this->status;
    }

    /**
     * @param int $status
     */
    public function setStatus(int $status): void
    {
        $this->status = $status;
    }

    /**
     * @return int
     */
    public function getViewed(): int
    {
        return $this->viewed;
    }

    /**
     * @param int $viewed
     */
    public function setViewed(int $viewed): void
    {
        $this->viewed = $viewed;
    }

    /**
     * @return int
     */
    public function getSent(): int
    {
        return $this->sent;
    }

    /**
     * @param int $sent
     */
    public function setSent(int $sent): void
    {
        $this->sent = $sent;
    }

    /**
     * @return int
     */
    public function getTimeCreate(): int
    {
        return $this->time_create;
    }

    /**
     * @param int $time_create
     */
    public function setTimeCreate(int $time_create): void
    {
        $this->time_create = $time_create;
    }

    /**
     * @return int
     */
    public function getTimeUpdate(): int
    {
        return $this->time_update;
    }

    /**
     * @param int $time_update
     */
    public function setTimeUpdate(int $time_update): void
    {
        $this->time_update = $time_update;
    }

    /**
     * @return string
     */
    public function getInformation(): string
    {
        return $this->information;
    }

    /**
     * @param string $information
     */
    public function setInformation(string $information): void
    {
        $this->information = $information;
    }


}