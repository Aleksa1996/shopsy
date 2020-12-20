<?php


namespace App\Shopsy\IdentityAccess\Main\Domain\Event;


use DateTimeImmutable;
use App\Common\Domain\Event\DomainEvent;

class LoginAttempted implements DomainEvent
{
    /**
     * @var UserId|UserEmail|UserUsername
     */
    private $identity;

    /**
     * @var DateTimeImmutable
     */
    private $occurredOn;

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
     * @return DateTimeImmutable
     */
    public function getOccurredOn()
    {
        return $this->occurredOn;
    }
}
