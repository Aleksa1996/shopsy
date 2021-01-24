<?php

namespace App\Shopsy\IdentityAccess\Main\Domain\Service\Access\Specification;

use App\Shopsy\IdentityAccess\Main\Domain\Model\Access\RoleRepository;
use App\Common\Domain\Validator\Specification\Specification;

class UniqueNameSpecification extends Specification
{
    /**
     * @var RoleRepository
     */
    private $roleRepository;

    /**
     * UniqueNameSpecification Constructor
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
        $role = $this->roleRepository->findByName(
            $object->getName()
        );

        return $role === null || $object->getId()->equals($role->getId());
    }
}
