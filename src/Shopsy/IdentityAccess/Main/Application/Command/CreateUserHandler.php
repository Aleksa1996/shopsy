<?php

namespace App\Shopsy\IdentityAccess\Main\Application\Command;

use App\Common\Application\Command\CommandHandler;
use App\Common\Infrastructure\Service\Hasher\Hasher;
use App\Common\Domain\Validator\ValidationNotificationHandler;
use App\Shopsy\IdentityAccess\Main\Domain\Model\Identity\User;
use App\Shopsy\IdentityAccess\Main\Domain\Model\Identity\UserEmail;
use App\Shopsy\IdentityAccess\Main\Domain\Model\Identity\UserActive;
use App\Shopsy\IdentityAccess\Main\Domain\Model\Identity\UserAvatar;
use App\Shopsy\IdentityAccess\Main\Domain\Model\Access\RoleRepository;
use App\Shopsy\IdentityAccess\Main\Domain\Model\Identity\UserFullName;
use App\Shopsy\IdentityAccess\Main\Domain\Model\Identity\UserPassword;
use App\Shopsy\IdentityAccess\Main\Domain\Model\Identity\UserUsername;
use App\Shopsy\IdentityAccess\Main\Domain\Model\Identity\UserRepository;
use App\Shopsy\IdentityAccess\Main\Application\Exception\Command\ValidationErrorCommandException;

class CreateUserHandler implements CommandHandler
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @var RoleRepository
     */
    private $roleRepository;

    /**
     * @var Hasher
     */
    private $hasher;

    /**
     * CreateUserHandler constructor.
     *
     * @param UserRepository $userRepository
     * @param RoleRepository $roleRepository
     * @param Hasher $hasher
     */
    public function __construct(UserRepository $userRepository, RoleRepository $roleRepository, Hasher $hasher)
    {
        $this->userRepository = $userRepository;
        $this->roleRepository = $roleRepository;
        $this->hasher = $hasher;
    }

    /**
     * @inheritDoc
     */
    public function execute(CreateUserCommand $command = null)
    {
        $user = new User(
            $this->userRepository->nextIdentity(),
            new UserFullName($command->getFullName()),
            new UserUsername($command->getUsername()),
            new UserEmail($command->getEmail()),
            new UserPassword($this->hasher->hash($command->getPassword())),
            new UserActive($command->getActive()),
            $command->getAvatar() ? new UserAvatar($command->getAvatar()) : null
        );

        $role = $this->roleRepository->findByIdentifier($user->getDefaultRoleIdentifier());
        $user->attachRole($role);

        $validationHandler = new ValidationNotificationHandler();
        $user->validate($validationHandler, $this->userRepository);

        if ($validationHandler->hasErrors()) {
            throw ValidationErrorCommandException::createFromValidationNotificationHandler($validationHandler);
        }

        $this->userRepository->add($user);
    }
}
