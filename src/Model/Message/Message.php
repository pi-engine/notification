<?php

namespace Notification\Model\Message;

class Message
{
    private $id;
    private $title;
    private $text;
    private $image;
    private $link;

    public function __construct(
        $title,
        $text ,
        $image = null,
        $link = null,
        $id = null
    )
    {
        $this->title=$title;
        $this->text=$text;
        $this->image=$image;
        $this->link=$link;
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
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return int
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @return int
     */
    public function getImage(): string
    {
        return $this->image;
    }

    /**
     * @return int
     */
    public function getLink(): string
    {
        return $this->link;
    }

    /**
     * @return int
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return int
     */
    public function getMessageId(): string
    {
        return $this->message_id;
    }

    /**
     * @return int
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @return int
     */
    public function getParentId(): string
    {
        return $this->parent_id;
    }
}