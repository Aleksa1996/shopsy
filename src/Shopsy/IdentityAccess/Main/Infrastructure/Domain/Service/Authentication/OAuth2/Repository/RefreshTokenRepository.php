<?php


namespace App\Shopsy\IdentityAccess\Main\Infrastructure\Domain\Service\Authentication\OAuth2\Repository;


use App\Common\Domain\Id;
use League\OAuth2\Server\Entities\RefreshTokenEntityInterface;
use App\Shopsy\IdentityAccess\Main\Domain\Model\Auth\RefreshToken;
use League\OAuth2\Server\Repositories\RefreshTokenRepositoryInterface;
use App\Shopsy\IdentityAccess\Main\Infrastructure\Domain\Service\Authentication\OAuth2\Entity\RefreshTokenEntity;
use App\Shopsy\IdentityAccess\Main\Domain\Model\Auth\RefreshTokenRepository as AppRefreshTokenRepository;

class RefreshTokenRepository implements RefreshTokenRepositoryInterface
{
    /**
     * @var AppRefreshTokenRepository $appRefreshTokenRepository
     */
    private $appRefreshTokenRepository;

    /**
     * RefreshTokenRepository Constructor
     *
     * @param AppRefreshTokenRepository $userRepository
     */
    public function __construct(AppRefreshTokenRepository $appRefreshTokenRepository)
    {
        $this->appRefreshTokenRepository = $appRefreshTokenRepository;
    }

    /**
     * @inheritdoc
     */
    public function getNewRefreshToken()
    {
        $refreshToken = new RefreshTokenEntity();
        $refreshToken->setIdentifier($this->appRefreshTokenRepository->nextIdentity());

        return $refreshToken;
    }

    /**
     * @inheritdoc
     */
    public function persistNewRefreshToken(RefreshTokenEntityInterface $refreshTokenEntity)
    {
        $appRefreshToken = new RefreshToken(
            $this->appRefreshTokenRepository->nextIdentity(),
            $refreshTokenEntity->getIdentifier(),
            $refreshTokenEntity->getAccessToken()->getIdentifier(),
            false,
            $refreshTokenEntity->getExpiryDateTime()
        );

        $this->appRefreshTokenRepository->add($appRefreshToken);
    }

    /**
     * @inheritdoc
     */
    public function revokeRefreshToken($tokenId)
    {
        $appRefreshToken = $this->appRefreshTokenRepository->findByIdentifier($tokenId);

        if ($appRefreshToken) {
            $appRefreshToken->revoke();
        }
    }

    /**
     * @inheritdoc
     */
    public function isRefreshTokenRevoked($tokenId)
    {
        $appRefreshToken = $this->appRefreshTokenRepository->findByIdentifier($tokenId);

        if (!$appRefreshToken) {
            return true;
        }

        return $appRefreshToken->getRevoked();
    }
}
