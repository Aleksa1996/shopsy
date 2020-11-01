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
     * User First name
     *
     * @var UserFirstName
     */
    protected $firstName;

    /**
     * User Last name
     *
     * @var UserLastName
     */
    protected $lastName;

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
     * @param UserFirstName $firstName
     * @param UserLastName $lastName
     * @param UserEmail $email
     * @param UserPassword $password
     */
    public function __construct(UserId $id, UserFirstName $firstName, UserLastName $lastName, UserEmail $email, UserPassword $password)
    {
        $this->setId($id);
        $this->setFirstName($firstName);
        $this->setLastName($lastName);
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
     * @return  UserFirstName
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set user First name
     *
     * @param UserFirstName $firstName
     *
     * @return  self
     */
    public function setFirstName(UserFirstName $firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get user Last name
     *
     * @return  UserLastName
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set user Last name
     *
     * @param UserLastName $lastName
     *
     * @return  self
     */
    public function setLastName(UserLastName $lastName)
    {
        $this->lastName = $lastName;

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
