<?php

namespace App\Shopsy\IdentityAccess\Main\Infrastructure\Delivery\Symfony\Security;

use App\Shopsy\IdentityAccess\Main\Domain\Model\Identity\UserId;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use App\Shopsy\IdentityAccess\Main\Domain\Model\Identity\UserRepository;
use App\Shopsy\IdentityAccess\Main\Domain\Model\Identity\UserUsername;

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
        //TODO: Check for exceptions
        $user = $this->userRepository->findByUsername(new UserUsername($username));

        if (!$user) {
            // TODO: THROW EXCEPTION
        }

        return new SecurityUser(
            $user->getId()->getId(),
            $user->getUsername()->getUsername()
        );
    }

    /**
     * @param int|string $id
     *
     * @return void
     */
    public function loadUserById($id)
    {
        //TODO: Check for exceptions
        $user = $this->userRepository->findById(new UserId($id));

        if (!$user) {
            // TODO: THROW EXCEPTION
        }

        return new SecurityUser(
            $user->getId()->getId(),
            $user->getUsername()->getUsername()
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
     * @inheritDoc
     */
    public function supportsClass(string $class)
    {
        return true;
    }
}
