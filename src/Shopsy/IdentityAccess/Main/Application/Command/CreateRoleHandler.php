<?php

namespace App\Shopsy\IdentityAccess\Main\Application\Command;

use App\Common\Application\Command\CommandHandler;
use App\Shopsy\IdentityAccess\Main\Domain\Model\Access\Role;
use App\Common\Domain\Validator\ValidationNotificationHandler;
use App\Shopsy\IdentityAccess\Main\Domain\Model\Access\RoleRepository;
use App\Shopsy\IdentityAccess\Main\Application\Transformer\RoleTransformer;
use App\Shopsy\IdentityAccess\Main\Application\Exception\Command\ValidationErrorCommandException;

class CreateRoleHandler implements CommandHandler
{
    /**
     * @var RoleRepository
     */
    private $roleRepository;

    /**
     * @var ArrayRoleTransformer
     */
    private $roleTransformer;

    /**
     * CreateRoleHandler constructor.
     *
     * @param RoleRepository $roleRepository
     * @param RoleTransformer $roleTransformer
     */
    public function __construct(RoleRepository $roleRepository, RoleTransformer $roleTransformer)
    {
        $this->roleRepository = $roleRepository;
        $this->roleTransformer = $roleTransformer;
    }

    /**
     * @inheritDoc
     */
    public function execute(CreateRoleCommand $command = null)
    {
        $role = new Role(
            $this->roleRepository->nextIdentity(),
            $command->getName(),
            $command->getIdentifier(),
            $command->getPermissions()
        );

        $validationHandler = new ValidationNotificationHandler();
        $role->validate(
            $validationHandler,
            $this->roleRepository
        );

        if ($validationHandler->hasErrors()) {
            throw ValidationErrorCommandException::createFromValidationNotificationHandler($validationHandler);
        }

        $this->roleRepository->add($role);
        $this->roleTransformer->write($role);

        return $this->roleTransformer->read();
    }
}
