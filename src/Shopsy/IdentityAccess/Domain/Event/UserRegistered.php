<?php

namespace App\Shopsy\IdentityAccess\Domain\Event;

use App\Common\Domain\DomainEvent;
use App\Shopsy\IdentityAccess\Domain\Model\UserId;
use DateTimeImmutable;

class UserRegistered implements DomainEvent
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
