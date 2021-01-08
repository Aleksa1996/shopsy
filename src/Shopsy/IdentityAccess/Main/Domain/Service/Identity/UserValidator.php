<?php

namespace App\Shopsy\IdentityAccess\Main\Domain\Service\Identity;

use App\Common\Domain\Validator\Validator;
use App\Shopsy\IdentityAccess\Main\Domain\Model\Identity\User;
use App\Common\Domain\Validator\ValidationNotificationHandler;
use App\Shopsy\IdentityAccess\Main\Domain\Model\Identity\UserRepository;
use App\Shopsy\IdentityAccess\Main\Domain\Service\Identity\Specification\UniqueEmail;
use App\Shopsy\IdentityAccess\Main\Domain\Service\Identity\Specification\UniqueUsername;

class UserValidator extends Validator
{
    /**
     * @var User
     */
    private $user;

    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * UserValidator Constructor
     *
     * @param ValidationNotificationHandler $notificationHandler
     * @param User
     * @param UserRepository $userRepository
     */
    public function __construct(ValidationNotificationHandler $notificationHandler, User $user, UserRepository $userRepository)
    {
        parent::__construct($notificationHandler);
        $this->setUser($user);
        $this->setUserRepository($userRepository);
    }

    /**
     * Set the value of user
     *
     * @param  User  $user
     *
     * @return  self
     */
    public function setUser(User $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Set the value of userRepository
     *
     * @param  UserRepository  $userRepository
     *
     * @return  self
     */
    public function setUserRepository(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function validate()
    {
        if (!$this->hasUniqueUsername()) {
            $this->notificationHandler->addError(
                sprintf('User with username "%s" already exists.', $this->user->getUsername()->getUsername()),
                'username'
            );
        }

        if (!$this->hasUniqueEmail()) {
            $this->notificationHandler->addError(
                sprintf('User with "%s" email already exists.', $this->user->getEmail()->getEmail()),
                'email'
            );
        }
    }

    /**
     * @return bool
     */
    private function hasUniqueUsername()
    {
        return (new UniqueUsername($this->userRepository))->isSatisfiedBy($this->user);
    }

    /**
     * @return bool
     */
    private function hasUniqueEmail()
    {
        return (new UniqueEmail($this->userRepository))->isSatisfiedBy($this->user);
    }
}
