<?php

namespace App\Common\Domain\Event;

use App\Common\Domain\Event\DomainEventSubscriber;
use App\Common\Domain\Event\StoredDomainEventRepository;

class PersistDomainEventSubscriber implements DomainEventSubscriber
{
    /**
     * @var StoredDomainEventRepository
     */
    private $storedDomainEventRepository;

    /**
     * PersistDomainEventSubscriber Constructor
     *
     * @param StoredDomainEventRepository $storedDomainEventRepository
     */
    public function __construct(StoredDomainEventRepository $storedDomainEventRepository)
    {
        $this->storedDomainEventRepository = $storedDomainEventRepository;
    }

    /**
     * @inheritDoc
     */
    public function handle($domainEvent)
    {
        $this->storedDomainEventRepository->append($domainEvent);
    }

    /**
     * @inheritDoc
     */
    public function isSubscribedTo($domainEvent)
    {
        return true;
    }
}
