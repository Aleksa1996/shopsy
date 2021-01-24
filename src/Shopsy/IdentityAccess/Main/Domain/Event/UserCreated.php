<?php

namespace App\Shopsy\IdentityAccess\Main\Domain\Event;

use DateTimeImmutable;
use App\Common\Domain\Event\DomainEvent;
use App\Common\Domain\Event\ImplementsDomainEvent;
use App\Common\Domain\Event\PublishableDomainEvent;
use App\Shopsy\IdentityAccess\Main\Domain\Model\Identity\UserId;

class UserCreated implements DomainEvent, PublishableDomainEvent
{
    use ImplementsDomainEvent;

    /**
     * @var UserId
     */
    private $userId;

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
     * @return string
     */
    public function getType()
    {
        return 'identity_access.UserCreated';
    }
}
