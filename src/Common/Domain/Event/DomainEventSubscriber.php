<?php

namespace App\Common\Domain\Event;

interface DomainEventSubscriber
{
    /**
     * @param DomainEvent $domainEvent
     */
    public function handle($domainEvent);

    /**
     * @param DomainEvent $domainEvent
     *
     * @return bool
     */
    public function isSubscribedTo($domainEvent);
}
