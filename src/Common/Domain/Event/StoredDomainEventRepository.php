<?php

namespace App\Common\Domain\Event;

interface StoredDomainEventRepository
{
    /**
     * @param DomainEvent $domainEvent
     *
     * @return void
     */
    public function append(DomainEvent $domainEvent);

    /**
     * @param mixed $id
     *
     * @return array
     */
    public function allStoredEventsSince($id);
}
