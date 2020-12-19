<?php

namespace App\Shopsy\IdentityAccess\Main\Domain\Event;

use DateTimeImmutable;
use App\Common\Domain\Event\DomainEvent;
use App\Shopsy\IdentityAccess\Main\Domain\Model\Identity\UserId;

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
     * UserRegistered Constructor.
     *
     * @param UserId $userId
     */
    public function __construct(UserId $userId)
    {
        $this->userId = $userId;
        $this->occurredOn = new DateTimeImmutable();
    }

    /**
     * @return UserId
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getOccurredOn()
    {
        return $this->occurredOn;
    }
}
