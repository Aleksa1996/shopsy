<?php

namespace App\Shopsy\IdentityAccess\Main\Domain\Service\Identity\Specification;

use App\Shopsy\IdentityAccess\Main\Domain\Model\Identity\UserRepository;
use App\Common\Domain\Validator\Specification\Specification;

class UniqueEmail extends Specification
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * UniqueEmailSpecification Constructor
     *
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param User $object
     *
     * @return boolean
     */
    public function isSatisfiedBy($object)
    {
        $user = $this->userRepository->findByEmail(
            $object->getEmail()
        );

        return $user === null || $object->getId()->equals($user->getId());
    }
}
