<?php

namespace App\Shopsy\IdentityAccess\Main\Infrastructure\Domain\Service\Authentication\OAuth2\Repository;

use App\Common\Domain\Id;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use App\Shopsy\IdentityAccess\Main\Domain\Model\Identity\UserId;
use League\OAuth2\Server\Entities\AccessTokenEntityInterface;
use App\Shopsy\IdentityAccess\Main\Domain\Model\Auth\AccessToken;
use League\OAuth2\Server\Repositories\AccessTokenRepositoryInterface;
use App\Shopsy\IdentityAccess\Main\Infrastructure\Domain\Service\Authentication\OAuth2\Entity\AccessTokenEntity;
use App\Shopsy\IdentityAccess\Main\Domain\Model\Auth\AccessTokenRepository as AppAccessTokenRepository;
use Doctrine\ORM\EntityManagerInterface;

class AccessTokenRepository implements AccessTokenRepositoryInterface
{
    /**
     * @var AppAccessTokenRepository
     */
    private $appAccessTokenRepository;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * AccessTokenRepository Constructor
     *
     * @param AppAccessTokenRepository $userRepository
     */
    public function __construct(AppAccessTokenRepository $appAccessTokenRepository, EntityManagerInterface $entityManager)
    {
        $this->appAccessTokenRepository = $appAccessTokenRepository;
        $this->entityManager = $entityManager;
    }

    /**
     * @inheritDoc
     */
    public function getNewToken(ClientEntityInterface $clientEntity, array $scopes, $userIdentifier = null)
    {
        $accessToken = new AccessTokenEntity();

        $accessToken->setClient($clientEntity);
        foreach ($scopes as $scope) {
            $accessToken->addScope($scope);
        }
        $accessToken->setUserIdentifier($userIdentifier);

        return $accessToken;
    }

    /**
     * @inheritDoc
     */
    public function persistNewAccessToken(AccessTokenEntityInterface $accessTokenEntity)
    {
        $appAccessToken = new AccessToken(
            $this->appAccessTokenRepository->nextIdentity(),
            new UserId($accessTokenEntity->getUserIdentifier()),
            new Id($accessTokenEntity->getClient()->getIdentifier()),
            $accessTokenEntity->getScopes(),
            false,
            $accessTokenEntity->getExpiryDateTime()
        );

        //TODO: check how to persist via client app repository
        $this->entityManager->persist($appAccessToken);
        $this->entityManager->flush();
        // $this->appAccessTokenRepository->add($appAccessToken);
    }

    /**
     * @inheritDoc
     */
    public function revokeAccessToken($tokenId)
    {
        $appAccessToken = $this->appAccessTokenRepository->findById(new Id($tokenId));

        if ($appAccessToken) {
            $appAccessToken->revoke();
        }
    }

    /**
     * @inheritDoc
     */
    public function isAccessTokenRevoked($tokenId)
    {
        $appAccessToken = $this->appAccessTokenRepository->findById(new Id($tokenId));

        if (!$appAccessToken) {
            return true;
        }

        return $appAccessToken->getRevoked();
    }
}
