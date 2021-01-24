<?php

namespace App\Common\Domain\Event;

use DateTimeImmutable;

interface DomainEvent
{
    /**
     * @return string
     */
    public function getType();

    /**
     * @return int
     */
    public function getEventVersion();

    /**
     * @return DateTimeImmutable
     */
    public function getOccurredOn();
}
