<?php

namespace App\Common\Domain\Event;

use App\Common\Domain\Id;

interface StoredDomainEventRepository
{
    /**
     * @param DomainEvent $domainEvent
     *
     * @return void
     */
    public function append(DomainEvent $domainEvent);

    /**
     * @param Id $id
     *
     * @return array
     */
    public function allStoredEventsSince(Id $id);
}
