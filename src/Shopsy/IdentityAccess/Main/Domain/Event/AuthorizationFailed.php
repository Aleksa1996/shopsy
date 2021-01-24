<?php


namespace App\Shopsy\IdentityAccess\Main\Domain\Event;


use DateTimeImmutable;
use App\Common\Domain\Event\DomainEvent;

class AuthorizationFailed implements DomainEvent
{
    /**
     * @var mixed
     */
    private $attribute;

    /**
     * @var mixed
     */
    private $subject;

    /**
     * @var DateTimeImmutable
     */
    private $occurredOn;

    /**
     * AuthorizationFailed Constructor.
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
     * @return DateTimeImmutable
     */
    public function getOccurredOn()
    {
        return $this->occurredOn;
    }
}
