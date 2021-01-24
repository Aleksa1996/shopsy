<?php

namespace App\Shopsy\IdentityAccess\Main\Domain\Service\Access\Specification;

use App\Shopsy\IdentityAccess\Main\Domain\Model\Access\RoleRepository;
use App\Common\Domain\Validator\Specification\Specification;

class UniqueIdentifierSpecification extends Specification
{
    /**
     * @var RoleRepository
     */
    private $roleRepository;

    /**
     * UniqueIdentifierSpecification Constructor
     *
     * @param RoleRepository $roleRepository
     */
    public function __construct(RoleRepository $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

    /**
     * @param User $object
     *
     * @return boolean
     */
    public function isSatisfiedBy($object)
    {
        $role = $this->roleRepository->findByIdentifier(
            $object->getIdentifier()
        );

        return $role === null || $object->getId()->equals($role->getId());
    }
}
