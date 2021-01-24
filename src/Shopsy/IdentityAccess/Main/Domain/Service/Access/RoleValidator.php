<?php

namespace App\Shopsy\IdentityAccess\Main\Domain\Service\Access;

use App\Common\Domain\Validator\Validator;
use App\Shopsy\IdentityAccess\Main\Domain\Model\Access\Role;
use App\Common\Domain\Validator\ValidationNotificationHandler;
use App\Shopsy\IdentityAccess\Main\Domain\Model\Access\RoleRepository;
use App\Shopsy\IdentityAccess\Main\Domain\Service\Access\Specification\UniqueIdentifierSpecification;
use App\Shopsy\IdentityAccess\Main\Domain\Service\Access\Specification\UniqueNameSpecification;

class RoleValidator extends Validator
{
    /**
     * @var Role
     */
    private $role;

    /**
     * @var RoleRepository
     */
    private $roleRepository;

    /**
     * RoleValidator Constructor
     *
     * @param ValidationNotificationHandler $notificationHandler
     * @param Role $role
     * @param RoleRepository $roleRepository
     */
    public function __construct(ValidationNotificationHandler $notificationHandler, Role $role, RoleRepository $roleRepository)
    {
        parent::__construct($notificationHandler);
        $this->setRole($role);
        $this->setRoleRepository($roleRepository);
    }

    /**
     * @param  Role  $role
     *
     * @return  self
     */
    public function setRole(Role $role)
    {
        $this->role = $role;

        return $this;
    }

    /**
     * @param  RoleRepository  $roleRepository
     *
     * @return  self
     */
    public function setRoleRepository(RoleRepository $roleRepository)
    {
        $this->roleRepository = $roleRepository;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function validate()
    {
        if (!$this->hasUniqueName()) {
            $this->notificationHandler->addError(
                sprintf('Role with name "%s" already exists.', $this->role->getName()),
                'name'
            );
        }

        if (!$this->hasUniqueIdentifier()) {
            $this->notificationHandler->addError(
                sprintf('Role with "%s" identifier already exists.', $this->role->getIdentifier()),
                'identifier'
            );
        }
    }

    /**
     * @return boolean
     */
    private function hasUniqueName()
    {
        return (new UniqueNameSpecification($this->roleRepository))->isSatisfiedBy($this->role);
    }

    /**
     * @return boolean
     */
    private function hasUniqueIdentifier()
    {
        return (new UniqueIdentifierSpecification($this->roleRepository))->isSatisfiedBy($this->role);
    }
}
