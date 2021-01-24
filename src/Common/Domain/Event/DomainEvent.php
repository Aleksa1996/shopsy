<?php

namespace App\Common\Domain\Event;

use DateTimeImmutable;

interface DomainEvent
{
    /**
     * @return DateTimeImmutable
     */
    public function getOccurredOn();
}
