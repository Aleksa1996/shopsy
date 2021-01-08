<?php

namespace App\Shopsy\IdentityAccess\Main\Domain\Model\Auth;


use DateTimeImmutable;
use App\Common\Domain\Id;

class RefreshToken
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
     * @var string
     */
    protected $accessTokenIdentifier;

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
     * RefreshToken constructor.
     *
     * @param Id $id
     * @param string accessTokenIdentifier
     * @param bool $revoked
     * @param DateTimeImmutable $expiresOn
     */
    public function __construct(Id $id, string $identifier, string $accessTokenIdentifier, bool $revoked, DateTimeImmutable $expiresOn)
    {
        $this->setId($id);
        $this->setIdentifier($identifier);
        $this->setAccessTokenIdentifier($accessTokenIdentifier);
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
     * @return  Id
     */
    public function getAccessTokenId()
    {
        return $this->accessTokenId;
    }

    /**
     * @param string $accessTokenId
     *
     * @return  self
     */
    public function setAccessTokenIdentifier(string $accessTokenIdentifier)
    {
        $this->accessTokenIdentifier = $accessTokenIdentifier;

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
