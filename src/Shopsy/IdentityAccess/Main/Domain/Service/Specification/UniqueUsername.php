<?php

namespace App\Shopsy\IdentityAccess\Main\Domain\Service\Specification;

use App\Shopsy\IdentityAccess\Main\Domain\Model\User\UserRepository;
use App\Common\Domain\Validator\Specification\Specification;

class UniqueUsername extends Specification
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * UniqueUsernameSpecification Constructor
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
        $user = $this->userRepository->findByUsername(
            $object->getUsername()
        );

        return $user === null || $object->getId()->equals($user->getId());
    }
}
