<?php

namespace App\Shopsy\IdentityAccess\Main\Domain\Model\Identity;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use App\Common\Domain\Event\DomainEventPublisher;
use App\Shopsy\IdentityAccess\Main\Domain\Event\UserCreated;
use App\Shopsy\IdentityAccess\Main\Domain\Model\Access\Role;
use App\Common\Domain\Validator\ValidationNotificationHandler;
use App\Shopsy\IdentityAccess\Main\Domain\Service\Identity\UserValidator;

class User
{
    /**
     * @var UserId
     */
    protected $id;

    /**
     * @var UserFullName
     */
    protected $fullName;

    /**
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
     * @var UserPassword
     */
    protected $password;

    /**
     * @var UserActive
     */
    protected $active;

    /**
     * @var UserAvatar
     */
    protected $avatar;

    /**
     * @var ArrayCollection<Role>
     */
    protected $roles;

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
    public function __construct(UserId $id, UserFullName $fullName, UserUsername $username, UserEmail $email, UserPassword $password, UserActive $active, UserAvatar $avatar = null, array $roles = [])
    {
        $this->setId($id);
        $this->setFullName($fullName);
        $this->setUsername($username);
        $this->setEmail($email);
        $this->setPassword($password);
        $this->setActive($active);
        $this->setAvatar($avatar);
        $this->setRoles($roles);
        $this->setCreatedOn(new DateTime());
        $this->setUpdatedOn(new DateTime());

        DomainEventPublisher::instance()
            ->publish(new UserCreated($id));
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
     * @return  UserActive
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * @param UserActive $active
     *
     * @return  self
     */
    public function setActive(UserActive $active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * @return  UserAvatar
     */
    public function getAvatar()
    {
        return $this->avatar;
    }

    /**
     * @param UserAvatar $avatar
     *
     * @return  self
     */
    public function setAvatar(?UserAvatar $avatar)
    {
        $this->avatar = $avatar;

        return $this;
    }

    /**
     * @return  Role[]
     */
    public function getRoles()
    {
        return $this->roles->toArray();
    }

    /**
     * @param  Role[]  $roles
     *
     * @return  self
     */
    public function setRoles(array $roles)
    {
        $this->roles = new ArrayCollection($roles);

        return $this;
    }

    /**
     * @param Role $role
     *
     * @return  Role[]
     */
    public function attachRole(Role $role)
    {
        foreach ($this->roles as $r) {
            if ($r->getId()->equals($role->getId())) {
                return $this;
            }
        }

        $this->roles[] = $role;

        return $this;
    }

    /**
     * @param Role $role
     *
     * @return  Role[]
     */
    public function detachRole(Role $role)
    {
        foreach ($this->roles as $key => $r) {
            if ($r->getId()->equals($role->getId())) {
                unset($this->roles[$key]);
            }
        }

        return $this;
    }

    /**
     * @param string $action
     * @param string $resource
     *
     * @return bool
     */
    public function hasPermissionOnResource(string $action, string $resource)
    {
        foreach ($this->roles as $r) {
            if ($r->hasPermission($action, $resource)) {
                return true;
            }
        }

        return false;
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

    /**
     * @param ValidationNotificationHandler $validationNotificationHandler
     * @param UserRepository $userRepository
     *
     * @return void
     */
    public function validate(ValidationNotificationHandler $validationNotificationHandler, UserRepository $userRepository)
    {
        (new UserValidator($validationNotificationHandler, $this, $userRepository))->validate();
    }
}
