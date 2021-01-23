<?php

namespace App\Shopsy\IdentityAccess\Main\Application\Command;

use App\Common\Domain\Id;
use App\Common\Application\Command\CommandHandler;
use App\Shopsy\IdentityAccess\Main\Domain\Model\Access\RoleRepository;
use App\Shopsy\IdentityAccess\Main\Application\Command\DestroyRoleCommand;
use App\Shopsy\IdentityAccess\Main\Application\Transformer\RoleTransformer;
use App\Shopsy\IdentityAccess\Main\Application\Exception\Command\RoleNotFoundCommandException;

class DestroyRoleHandler implements CommandHandler
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
     * DestroyRoleHandler constructor.
     *
     * @param RoleRepository $roleRepository
     * @param RoleTransformer $roleDataTransformer
     */
    public function __construct(RoleRepository $roleRepository, RoleTransformer $roleTransformer)
    {
        $this->roleRepository = $roleRepository;
        $this->roleTransformer = $roleTransformer;
    }

    /**
     * @inheritDoc
     */
    public function execute(DestroyRoleCommand $command = null)
    {
        $role = $this->roleRepository->findById(new Id($command->getId()));
        if (!$role) {
            throw new RoleNotFoundCommandException();
        }

        $this->roleRepository->remove($role);

        $this->roleTransformer->write($role);

        return $this->roleTransformer->read();
    }
}
