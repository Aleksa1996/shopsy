<?php

namespace App\Shopsy\IdentityAccess\Main\Application\Command;

use App\Common\Domain\Id;
use App\Common\Application\Command\CommandHandler;
use App\Common\Domain\Validator\ValidationNotificationHandler;
use App\Shopsy\IdentityAccess\Main\Domain\Model\Identity\UserId;
use App\Shopsy\IdentityAccess\Main\Domain\Model\Access\RoleRepository;
use App\Shopsy\IdentityAccess\Main\Domain\Model\Identity\UserRepository;
use App\Shopsy\IdentityAccess\Main\Application\Transformer\UserTransformer;
use App\Shopsy\IdentityAccess\Main\Application\Command\ReplaceRolesOfUserCommand;
use App\Shopsy\IdentityAccess\Main\Application\Exception\Command\RoleNotFoundCommandException;
use App\Shopsy\IdentityAccess\Main\Application\Exception\Command\UserNotFoundCommandException;
use App\Shopsy\IdentityAccess\Main\Application\Exception\Command\ValidationErrorCommandException;

class ReplaceRolesOfUserHandler implements CommandHandler
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
     * @var ArrayUserTransformer
     */
    private $userTransformer;

    /**
     * ReplaceRolesOfUserHandler constructor.
     *
     * @param UserRepository $userRepository
     * @param RoleRepository $roleRepository
     * @param UserTransformer $userTransformer
     */
    public function __construct(UserRepository $userRepository, RoleRepository $roleRepository, UserTransformer $userTransformer)
    {
        $this->userRepository = $userRepository;
        $this->roleRepository = $roleRepository;
        $this->userTransformer = $userTransformer;
    }

    /**
     * @inheritDoc
     */
    public function execute(ReplaceRolesOfUserCommand $command = null)
    {
        $user = $this->userRepository->findById(new UserId($command->getId()));

        if (!$user) {
            throw new UserNotFoundCommandException();
        }

        $user->detachAllRoles();

        foreach ($command->getRoles() as $roleId) {
            $role = $this->roleRepository->findById(new Id($roleId));

            if (!$role) {
                throw new RoleNotFoundCommandException();
            }

            if (!$user->hasRole($role)) {
                $user->attachRole($role);
            }
        }

        $validationHandler = new ValidationNotificationHandler();
        $user->validate(
            $validationHandler,
            $this->userRepository
        );

        if ($validationHandler->hasErrors()) {
            throw ValidationErrorCommandException::createFromValidationNotificationHandler($validationHandler);
        }

        $this->userTransformer->write($user);

        return $this->userTransformer->read();
    }
}
