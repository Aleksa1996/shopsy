<?php

namespace App\Shopsy\Users\Domain\Model;

use App\Shared\Domain\DomainEventPublisher;
use DateTime;

class User
{
    /**
     * User id
     *
     * @var UserId
     */
    protected $id;

    /**
     * User Full name
     *
     * @var UserFullName
     */
    protected $fullName;

    /**
     * User name
     *
     * @var UserUsername
     */
    protected $username;

    /**
     * User email
     *
     * @var UserEmail
     */
    protected $email;

    /**
     * User password
     *
     * @var UserPassword
     */
    protected $password;

    /**
     * @var DateTime
     */
    protected $createdOn;

    /**
     * @var DateTime
     */
    protected $updatedOn;

    /**
     * User constructor.
     *
     * @param UserId $id
     * @param UserFullName $fullName
     * @param UserUsername $username
     * @param UserEmail $email
     * @param UserPassword $password
     */
    public function __construct(UserId $id, UserFullName $fullName, UserUsername $username, UserEmail $email, UserPassword $password)
    {
        $this->setId($id);
        $this->setFullName($fullName);
        $this->setUsername($username);
        $this->setEmail($email);
        $this->setPassword($password);
        $this->setCreatedOn(new DateTime());
        $this->setUpdatedOn(new DateTime());

        DomainEventPublisher::instance()
            ->publish(new UserRegistered($id));
    }

    /**
     * Get user id
     *
     * @return  UserId
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set user id
     *
     * @param UserId $id
     *
     * @return  self
     */
    public function setId(UserId $id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get user First name
     *
     * @return  UserFullName
     */
    public function getFullName()
    {
        return $this->fullName;
    }

    /**
     * Set user First name
     *
     * @param UserFullName $fullName
     *
     * @return  self
     */
    public function setFullName(UserFullName $fullName)
    {
        $this->fullName = $fullName;

        return $this;
    }

    /**
     * Get user Last name
     *
     * @return  UserUsername
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set user Last name
     *
     * @param UserUsername $username
     *
     * @return  self
     */
    public function setUsername(UserUsername $username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get user email
     *
     * @return  UserEmail
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set user email
     *
     * @param UserEmail $email
     *
     * @return  self
     */
    public function setEmail(UserEmail $email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get user password
     *
     * @return  UserPassword
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set user password
     *
     * @param UserPassword $password
     *
     * @return  self
     */
    public function setPassword(UserPassword $password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @return DateTime
     */
    public function getCreatedOn(): DateTime
    {
        return $this->createdOn;
    }

    /**
     * @param DateTime $createdOn
     *
     * @return User
     */
    public function setCreatedOn(DateTime $createdOn): User
    {
        $this->createdOn = $createdOn;

        return $this;
    }

    /**
     * @return DateTime
     */
    public function getUpdatedOn(): DateTime
    {
        return $this->updatedOn;
    }

    /**
     * @param DateTime $updatedOn
     *
     * @return User
     */
    public function setUpdatedOn(DateTime $updatedOn): User
    {
        $this->updatedOn = $updatedOn;

        return $this;
    }

}
