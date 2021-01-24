<?php

namespace App\Common\Domain\Event;

use App\Common\Domain\Id;

class StoredDomainEvent implements DomainEvent
{
    /**
     * @var Id
     */
    private $id;

    /**
     * @var string
     */
    private $type;

    /**
     * @var string
     */
    private $body;

    /**
     * @var \DateTimeImmutable
     */
    private $occurredOn;

    /**
     * @param Id $id
     * @param string $type
     * @param \DateTimeImmutable $occurredOn
     * @param string $body
     */
    public function __construct(Id $id, string $type, \DateTimeImmutable $occurredOn, string $body)
    {
        $this->id = $id;
        $this->type = $type;
        $this->body = $body;
        $this->occurredOn = $occurredOn;
    }

    /**
     * @return Id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getOccurredOn()
    {
        return $this->occurredOn;
    }
}
