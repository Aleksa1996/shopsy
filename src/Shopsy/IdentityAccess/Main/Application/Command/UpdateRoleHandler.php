<?php

namespace App\Shopsy\IdentityAccess\Main\Application\Command;

use DateTimeImmutable;
use App\Common\Domain\Id;
use App\Common\Application\Command\CommandHandler;
use App\Common\Domain\Validator\ValidationNotificationHandler;
use App\Shopsy\IdentityAccess\Main\Domain\Model\Access\RoleRepository;
use App\Shopsy\IdentityAccess\Main\Application\Command\UpdateRoleCommand;
use App\Shopsy\IdentityAccess\Main\Application\Transformer\RoleTransformer;
use App\Shopsy\IdentityAccess\Main\Application\Exception\Command\RoleNotFoundCommandException;
use App\Shopsy\IdentityAccess\Main\Application\Exception\Command\ValidationErrorCommandException;

class UpdateRoleHandler implements CommandHandler
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
     * UpdateRoleHandler constructor.
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
    public function execute(UpdateRoleCommand $command = null)
    {
        $role = $this->roleRepository->findById(new Id($command->getId()));

        if (!$role) {
            throw new RoleNotFoundCommandException();
        }

        if ($command->getName())
            $role->setName($command->getName());

        if ($command->getIdentifier())
            $role->setIdentifier($command->getIdentifier());

        if ($command->getActive() !== null)
            $role->setActive($command->getActive());

        if ($command->getPermissions())
            $role->setPermissions($command->getPermissions());

        $role->setUpdatedOn(new DateTimeImmutable());

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
