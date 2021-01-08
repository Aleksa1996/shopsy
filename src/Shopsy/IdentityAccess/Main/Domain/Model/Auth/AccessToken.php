<?php

namespace App\Shopsy\IdentityAccess\Main\Domain\Model\Auth;


use DateTimeImmutable;
use App\Common\Domain\Id;
use App\Shopsy\IdentityAccess\Main\Domain\Model\Identity\UserId;

class AccessToken
{
    /**
     * @var Id
     */
    protected $id;

    /**
     * @var string
     */
    protected $identifier;

    /**
     * @var UserId
     */
    protected $userId;

    /**
     * @var Id
     */
    protected $clientId;

    /**
     * @var array
     */
    protected $scopes;

    /**
     * @var bool
     */
    protected $revoked;

    /**
     * @var DateTimeImmutable
     */
    protected $createdOn;

    /**
     * @var DateTimeImmutable
     */
    protected $updatedOn;

    /**
     * @var DateTimeImmutable
     */
    protected $expiresOn;

    /**
     * AccessToken constructor.
     *
     * @param Id $id
     * @param string $identifier
     * @param UserId $userId
     * @param Id $clientId
     * @param array $scopes
     * @param bool $revoked
     * @param DateTimeImmutable $expiresOn
     */
    public function __construct(Id $id, string $identifier, UserId $userId, Id $clientId, array $scopes, bool $revoked, DateTimeImmutable $expiresOn)
    {
        $this->setId($id);
        $this->setIdentifier($identifier);
        $this->setUserId($userId);
        $this->setClientId($clientId);
        $this->setScopes($scopes);
        $this->setRevoked($revoked);
        $this->setCreatedOn(new DateTimeImmutable());
        $this->setUpdatedOn(new DateTimeImmutable());
        $this->setExpiresOn($expiresOn);
    }

    /**
     * @return  Id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param Id $id
     *
     * @return  self
     */
    public function setId(Id $id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return  string
     */
    public function getIdentifier()
    {
        return $this->identifier;
    }

    /**
     * @param string $identifier
     *
     * @return  self
     */
    public function setIdentifier(string $identifier)
    {
        $this->identifier = $identifier;

        return $this;
    }

    /**
     * @return  UserId
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @param UserId $userId
     *
     * @return  self
     */
    public function setUserId(UserId $userId)
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * @return  Id
     */
    public function getClientId()
    {
        return $this->clientId;
    }

    /**
     * @param Id $clientId
     *
     * @return  self
     */
    public function setClientId(Id $clientId)
    {
        $this->clientId = $clientId;

        return $this;
    }

    /**
     * @return  array
     */
    public function getScopes()
    {
        return $this->scopes;
    }

    /**
     * @param array $scopes
     *
     * @return  self
     */
    public function setScopes(array $scopes)
    {
        $this->scopes = $scopes;

        return $this;
    }

    /**
     * @return  bool
     */
    public function getRevoked()
    {
        return $this->revoked;
    }

    /**
     * @param bool $revoked
     *
     * @return  self
     */
    public function setRevoked(bool $revoked)
    {
        $this->revoked = $revoked;

        return $this;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getCreatedOn()
    {
        return $this->createdOn;
    }

    /**
     * @param DateTimeImmutable $createdOn
     *
     * @return self
     */
    public function setCreatedOn(DateTimeImmutable $createdOn)
    {
        $this->createdOn = $createdOn;

        return $this;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getUpdatedOn()
    {
        return $this->updatedOn;
    }

    /**
     * @param DateTimeImmutable $updatedOn
     *
     * @return self
     */
    public function setUpdatedOn(DateTimeImmutable $updatedOn)
    {
        $this->updatedOn = $updatedOn;

        return $this;
    }

    /**
     * @return  DateTimeImmutable
     */
    public function getExpiresOn()
    {
        return $this->expiresOn;
    }

    /**
     * @param  DateTimeImmutable  $expiresOn
     *
     * @return  self
     */
    public function setExpiresOn(DateTimeImmutable $expiresOn)
    {
        $this->expiresOn = $expiresOn;

        return $this;
    }

    /**
     * @return self
     */
    public function revoke()
    {
        $this->revoked = true;

        return $this;
    }
}
