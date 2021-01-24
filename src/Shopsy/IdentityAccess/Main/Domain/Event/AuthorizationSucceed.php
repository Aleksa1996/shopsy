<?php


namespace App\Shopsy\IdentityAccess\Main\Domain\Event;


use DateTimeImmutable;
use App\Common\Domain\Event\DomainEvent;
use App\Common\Domain\Event\ImplementsDomainEvent;
use App\Common\Domain\Event\PublishableDomainEvent;

class AuthorizationSucceed implements DomainEvent, PublishableDomainEvent
{
    use ImplementsDomainEvent;

    /**
     * @var mixed
     */
    private $attribute;

    /**
     * @var mixed
     */
    private $subject;

    /**
     * AuthorizationSucceed Constructor.
     *
     * @param mixed $attribute
     * @param mixed $subject
     */
    public function __construct($attribute, $subject)
    {
        $this->attribute = $attribute;
        $this->subject = $subject;
        $this->occurredOn = new DateTimeImmutable();
    }

    /**
     * @return mixed $attribute
     */
    public function getAttribute()
    {
        return $this->attribute;
    }

    /**
     * @return mixed $subject
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return 'identity_access.AuthorizationSucceed';
    }
}
