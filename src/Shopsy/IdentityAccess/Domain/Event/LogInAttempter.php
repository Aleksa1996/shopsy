<?php


namespace App\DBP\IdentityAccess\Domain\Event;


use DateTimeImmutable;
use App\Common\Domain\Event\DomainEvent;
use App\Shopsy\IdentityAccess\Domain\Model\User\UserEmail;

class LogInAttempted implements DomainEvent
{
    /**
     * @var UserEmail
     */
    private $email;

    /**
     * @var DateTimeImmutable
     */
    private $occurredOn;

    /**
     * LogInAttempted constructor.
     *
     * @param UserEmail $email
     */
    public function __construct(UserEmail $email)
    {
        $this->email = $email;
        $this->occurredOn = new DateTimeImmutable();
    }

    /**
     * Get user email
     *
     * @return UserEmail
     */
    public function email()
    {
        return $this->email;
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