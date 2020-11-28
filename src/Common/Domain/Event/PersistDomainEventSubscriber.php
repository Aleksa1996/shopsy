<?php

namespace App\Common\Domain\Event;


use App\Common\Application\EventStore;
use App\Common\Domain\Event\PublishableDomainEvent;

class PersistDomainEventSubscriber implements DomainEventSubscriber
{
    /**
     * @var EventStore
     */
    private $eventStore;

    /**
     * PersistDomainEventSubscriber constructor.
     *
     * @param $anEventStore
     */
    public function __construct($anEventStore)
    {
        $this->eventStore = $anEventStore;
    }

    /**
     * Handle domain event
     *
     * @param DomainEvent $aDomainEvent
     */
    public function handle($aDomainEvent)
    {
        $this->eventStore->append($aDomainEvent);
    }

    /**
     * Check if it is subscribed to domain event
     *
     * @param DomainEvent $aDomainEvent
     *
     * @return bool
     */
    public function isSubscribedTo($aDomainEvent)
    {
        return $aDomainEvent instanceof PublishableDomainEvent;
    }
}