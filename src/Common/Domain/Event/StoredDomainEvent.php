<?php

namespace App\Common\Domain\Event;

class StoredDomainEvent implements DomainEvent
{
    use ImplementsDomainEvent;

    /**
     * @var mixed
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
     * @param string $type
     * @param string $body
     * @param \DateTimeImmutable $occurredOn
     */
    public function __construct(string $type, string $body, \DateTimeImmutable $occurredOn)
    {
        $this->type = $type;
        $this->body = $body;
        $this->occurredOn = $occurredOn;
    }

    /**
     * @return mixed
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
}
