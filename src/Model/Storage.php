<?php

namespace Notification\Model;

class Storage
{
    private mixed  $id;
    private int    $user_id;
    private int    $status;
    private int    $viewed;
    private int    $sent;
    private int    $time_create;
    private int    $time_update;
    private string $information;

    public function __construct(
        $user_id,
        $status,
        $viewed,
        $sent,
        $time_create,
        $time_update,
        $information,
        $id = null
    ) {
        $this->user_id     = $user_id;
        $this->status      = $status;
        $this->viewed      = $viewed;
        $this->sent      = $sent;
        $this->time_create = $time_create;
        $this->time_update = $time_update;
        $this->information = $information;
        $this->id          = $id;
    }

    /**
     * @return mixed
     */
    public function getId(): mixed
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->user_id;
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
    public function getViewed(): int
    {
        return $this->viewed;
    }

    /**
     * @return int
     */
    public function getSent(): int
    {
        return $this->sent;
    }

    /**
     * @return int
     */
    public function getTimeCreate(): int
    {
        return $this->time_create;
    }

    /**
     * @return int
     */
    public function getTimeUpdate(): int
    {
        return $this->time_update;
    }

    /**
     * @return string
     */
    public function getInformation(): string
    {
        return $this->information;
    }
}