<?php

namespace App\Common\Domain\Event;

use DateTime;

interface DomainEvent
{
    /**
     * @return DateTime
     */
    public function getOccurredOn();
}
