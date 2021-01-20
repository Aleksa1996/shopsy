<?php

namespace App\Shopsy\IdentityAccess\Main\Infrastructure\Delivery\Symfony\Security;

use Symfony\Component\Security\Core\User\UserInterface;
use App\Shopsy\IdentityAccess\Main\Domain\Model\Identity\UserId;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use App\Shopsy\IdentityAccess\Main\Domain\Model\Identity\UserRepository;

class SecurityUserProvider implements UserProviderInterface
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * UserProvider Constructor
     *
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @inheritDoc
     */
    public function loadUserByUsername(string $username)
    {
        try {
            $user = $this->userRepository->findById(new UserId($username));
        } catch (\Exception $e) {
            return null;
        }

        if (!$user) {
            return null;
        }

        $roles = [];
        foreach ($user->getRoles() as $r) {
            $roles[] = $r->getIdentifier();
        }

        return new SecurityUser(
            $user->getId()->getId(),
            $user->getUsername()->getUsername(),
            $roles
        );
    }

    /**
     * @inheritDoc
     */
    public function refreshUser(UserInterface $user)
    {
        return $user;
    }

    /**
     * Tells Symfony to use this provider for this User class.
     */
    public function supportsClass(string $class)
    {
        return true;
    }
}
