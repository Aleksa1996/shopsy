<?php

namespace App\Shopsy\IdentityAccess\Main\Domain\Model\Auth;


use DateTime;
use App\Common\Domain\Id;

class Client
{
    /**
     * @var Id
     */
    protected $id;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $secret;

    /**
     * @var string
     */
    protected $redirectUri;

    /**
     * @var bool
     */
    protected $active;

    /**
     * @var bool
     */
    protected $confidential;

    /**
     * @var bool
     */
    protected $usedForGeneralPurposeAuthentication;

    /**
     * @var DateTime
     */
    protected $createdOn;

    /**
     * @var DateTime
     */
    protected $updatedOn;

    /**
     * Client constructor.
     *
     * @param Id $id
     * @param string $name
     * @param string $secret
     * @param string $redirectUri
     * @param bool $active
     * @param bool $confidential
     * @param bool $usedForGeneralPurposeAuthentication
     */
    public function __construct(Id $id, string $name, string $secret, string $redirectUri, bool $active, bool $confidential, bool $usedForGeneralPurposeAuthentication = false)
    {
        $this->setId($id);
        $this->setName($name);
        $this->setSecret($secret);
        $this->setRedirectUri($redirectUri);
        $this->setActive($active);
        $this->setConfidential($confidential);
        $this->setUsedForGeneralPurposeAuthentication($usedForGeneralPurposeAuthentication);
        $this->setCreatedOn(new DateTime());
        $this->setUpdatedOn(new DateTime());
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
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return  self
     */
    public function setName(string $name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return  string
     */
    public function getSecret()
    {
        return $this->secret;
    }

    /**
     * @param string $secret
     *
     * @return  self
     */
    public function setSecret(string $secret)
    {
        $this->secret = $secret;

        return $this;
    }

    /**
     * @return  string
     */
    public function getRedirectUri()
    {
        return $this->redirectUri;
    }

    /**
     * @param string $redirectUri
     *
     * @return  self
     */
    public function setRedirectUri(string $redirectUri)
    {
        $this->redirectUri = $redirectUri;

        return $this;
    }

    /**
     * @return  bool
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * @param bool $active
     *
     * @return  self
     */
    public function setActive(bool $active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * @return  bool
     */
    public function getConfidential()
    {
        return $this->confidential;
    }

    /**
     * @param  bool  $confidential
     *
     * @return  self
     */
    public function setConfidential(bool $confidential)
    {
        $this->confidential = $confidential;

        return $this;
    }

    /**
     * @return  bool
     */
    public function getUsedForGeneralPurposeAuthentication()
    {
        return $this->usedForGeneralPurposeAuthentication;
    }

    /**
     * @param  bool  $usedForGeneralPurposeAuthentication
     *
     * @return  self
     */
    public function setUsedForGeneralPurposeAuthentication($usedForGeneralPurposeAuthentication)
    {
        $this->usedForGeneralPurposeAuthentication = $usedForGeneralPurposeAuthentication;

        return $this;
    }

    /**
     * @return DateTime
     */
    public function getCreatedOn()
    {
        return $this->createdOn;
    }

    /**
     * @param DateTime $createdOn
     *
     * @return self
     */
    public function setCreatedOn(DateTime $createdOn)
    {
        $this->createdOn = $createdOn;

        return $this;
    }

    /**
     * @return DateTime
     */
    public function getUpdatedOn()
    {
        return $this->updatedOn;
    }

    /**
     * @param DateTime $updatedOn
     *
     * @return self
     */
    public function setUpdatedOn(DateTime $updatedOn)
    {
        $this->updatedOn = $updatedOn;

        return $this;
    }
}
