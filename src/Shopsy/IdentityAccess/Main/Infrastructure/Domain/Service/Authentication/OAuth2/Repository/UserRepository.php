<?php

namespace App\Shopsy\IdentityAccess\Main\Infrastructure\Domain\Service\Authentication\OAuth2\Repository;

use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Exception\OAuthServerException;
use App\Shopsy\IdentityAccess\Main\Domain\Model\Identity\UserEmail;
use App\Shopsy\IdentityAccess\Main\Domain\Service\PasswordHasher;
use League\OAuth2\Server\Repositories\UserRepositoryInterface;
use App\Shopsy\IdentityAccess\Main\Domain\Model\Identity\UserUsername;
use App\Shopsy\IdentityAccess\Main\Domain\Model\Identity\UserRepository as AppUserRepository;
use App\Shopsy\IdentityAccess\Main\Infrastructure\Domain\Service\Authentication\OAuth2\Entity\UserEntity;

class UserRepository implements UserRepositoryInterface
{
    /**
     * @var AppUserRepository
     */
    private $appUserRepository;

    /**
     * @var PasswordHasher
     */
    private $userPasswordHasher;

    /**
     * UserRepository Constructor
     *
     * @param AppUserRepository $appUserRepository
     * @param PasswordHasher $passwordHasher
     */
    public function __construct(AppUserRepository $appUserRepository, PasswordHasher $passwordHasher)
    {
        $this->appUserRepository = $appUserRepository;
        $this->userPasswordHasher = $passwordHasher;
    }

    /**
     * @inheritDoc
     */
    public function getUserEntityByUserCredentials($username, $password, $grantType, ClientEntityInterface $clientEntity)
    {
        $appUser = null;
        try {
            $appUser = $this->appUserRepository->findByEmail(new UserEmail($username));
        } catch (\Exception $e) {
            $appUser = $this->appUserRepository->findByUsername(new UserUsername($username));
        }

        if (!$appUser) {
            throw OAuthServerException::invalidCredentials();
        }

        $isPasswordValid = $this->userPasswordHasher->verify($password, $appUser->getPassword()->getPassword());
        if (!$isPasswordValid) {
            throw OAuthServerException::invalidCredentials();
        }

        $user = new UserEntity();
        $user->setIdentifier($appUser->getId()->getId());
        return $user;
    }
}
