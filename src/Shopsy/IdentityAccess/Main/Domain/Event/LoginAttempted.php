<?php


namespace App\Shopsy\IdentityAccess\Main\Domain\Event;


use DateTimeImmutable;
use App\Common\Domain\Event\DomainEvent;
use App\Common\Domain\Event\ImplementsDomainEvent;

class LoginAttempted implements DomainEvent
{
    use ImplementsDomainEvent;

    /**
     * @var UserId|UserEmail|UserUsername
     */
    private $identity;

    /**
     * LoginAttempted Constructor.
     *
     * @param UserId|UserEmail|UserUsername $identity
     */
    public function __construct($identity)
    {
        $this->identity = $identity;
        $this->occurredOn = new DateTimeImmutable();
    }

    /**
     * @return UserId|UserEmail|UserUsername $identity
     */
    public function getIdentity()
    {
        return $this->identity;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return 'identity_access.LoginAttempted';
    }
}
