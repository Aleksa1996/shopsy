<?php

namespace App\Shopsy\IdentityAccess\Infrastructure\Domain\Authentication\OAuth2\Repository;

use App\Shopsy\IdentityAccess\Domain\Model\PasswordHasher;
use App\Shopsy\IdentityAccess\Infrastructure\Domain\Authentication\OAuth2\Entity\User;
use App\Shopsy\IdentityAccess\Domain\Model\UserEmail;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Exception\OAuthServerException;
use League\OAuth2\Server\Repositories\UserRepositoryInterface;
use App\Shopsy\IdentityAccess\Domain\Model\UserRepository as DomainUserRepository;

class UserRepository implements UserRepositoryInterface
{
    /**
     * @var DomainUserRepository
     */
    private $userRepository;

    /**
     * @var PasswordHasher
     */
    private $userPasswordHasher;

    public function __construct(DomainUserRepository $userRepository, PasswordHasher $passwordHasher)
    {
        $this->userRepository = $userRepository;
        $this->userPasswordHasher = $passwordHasher;
    }

    /**
     * @inheritDoc
     *
     * @throws OAuthServerException
     */
    public function getUserEntityByUserCredentials($username, $password, $grantType, ClientEntityInterface $clientEntity)
    {
        $domainUser = $this->userRepository->findByEmail(new UserEmail($username));
        if ($domainUser === null) {
            return null;
        }

        $isPasswordValid = $this->userPasswordHasher->verify($password, $domainUser->getPassword()->getPassword());
        if (!$isPasswordValid) {
            throw OAuthServerException::invalidCredentials();
        }

        return new User();
    }
}
