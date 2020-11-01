<?php

namespace App\Shared\Domain;

use DateTime;

interface DomainEvent
{
    /**
     * @return DateTime
     */
    public function occurredOn();
}
