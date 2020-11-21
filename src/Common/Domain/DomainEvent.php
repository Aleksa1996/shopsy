<?php

namespace App\Common\Domain;

use DateTime;

interface DomainEvent
{
    /**
     * @return DateTime
     */
    public function occurredOn();
}
