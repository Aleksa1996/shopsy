<?php

namespace App\Common\Domain\Event;

trait ImplementsDomainEvent
{
    /**
     * @var int
     */
    private $eventVersion = 1;

    /**
     * @var DateTimeImmutable
     */
    private $occurredOn;

    /**
     * @return int
     */
    public function getEventVersion()
    {
        return $this->eventVersion;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getOccurredOn()
    {
        return $this->occurredOn;
    }
}
