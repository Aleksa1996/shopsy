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
     * @var Id
     */
    protected $accessTokenId;

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
     * @param Id $accessTokenId
     * @param bool $revoked
     * @param DateTimeImmutable $expiresOn
     */
    public function __construct(Id $id, Id $accessTokenId, bool $revoked, DateTimeImmutable $expiresOn)
    {
        $this->setId($id);
        $this->setAccessTokenId($accessTokenId);
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
     * @return  Id
     */
    public function getAccessTokenId()
    {
        return $this->accessTokenId;
    }

    /**
     * @param Id $accessTokenId
     *
     * @return  self
     */
    public function setAccessTokenId(Id $accessTokenId)
    {
        $this->accessTokenId = $accessTokenId;

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
