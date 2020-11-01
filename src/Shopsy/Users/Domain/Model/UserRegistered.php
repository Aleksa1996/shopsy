<?php

namespace App\Shopsy\Users\Domain\Model;

use App\Shared\Domain\DomainEvent;
use App\Shared\Domain\Event\PublishableDomainEvent;
use DateTimeImmutable;

class UserRegistered implements DomainEvent, PublishableDomainEvent
{
    /**
     * @var UserId
     */
    private $userId;

    /**
     * @var DateTimeImmutable
     */
    private $occurredOn;

    /**
     * UserRegistered constructor.
     *
     * @param UserId $userId
     */
    public function __construct(UserId $userId)
    {
        $this->userId = $userId;
        $this->occurredOn = new DateTimeImmutable();
    }

    /**
     * Get user Id
     *
     * @return UserId
     */
    public function userId()
    {
        return $this->userId;
    }

    /**
     * Get occurred on timestamp
     *
     * @return DateTimeImmutable
     */
    public function occurredOn()
    {
        return $this->occurredOn;
    }
}
