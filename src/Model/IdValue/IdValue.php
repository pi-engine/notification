<?php

namespace Notification\Model\IdValue;

class IdValue
{
    private $id;
    private $title;
    private $type;

    public function __construct(
        $title,
        $type,
        $id = null
    )
    {
        $this->title=$title;
        $this->type=$type;
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
    public function getType(): String
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getTitle(): String
    {
        return $this->title;
    }
}