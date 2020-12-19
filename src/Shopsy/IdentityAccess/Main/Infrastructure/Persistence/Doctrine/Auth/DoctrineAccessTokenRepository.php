<?php

namespace App\Shopsy\IdentityAccess\Main\Infrastructure\Persistence\Doctrine\Auth;

use App\Common\Domain\Id;
use Doctrine\Persistence\ManagerRegistry;
use App\Shopsy\IdentityAccess\Main\Domain\Model\Auth\AccessToken;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use App\Shopsy\IdentityAccess\Main\Domain\Model\Auth\AccessTokenRepository;

class DoctrineAccessTokenRepository extends ServiceEntityRepository implements AccessTokenRepository
{
    /**
     * AccessTokenRepository constructor.
     *
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AccessToken::class);
    }

    /**
     * @inheritDoc
     */
    public function findById(Id $id)
    {
        return $this->find($id);
    }

    /**
     * @inheritDoc
     *
     * @throws ORMException
     */
    public function add(AccessToken $accessToken)
    {
        $this->getEntityManager()->persist($accessToken);
    }

    /**
     * @inheritDoc
     *
     * @throws ORMException
     */
    public function remove(AccessToken $accessToken)
    {
        $this->getEntityManager()->remove($accessToken);
    }

    /**
     * @inheritDoc
     */
    public function nextIdentity()
    {
        return new Id();
    }

    /**
     * @inheritDoc
     */
    public function query($query)
    {
    }
}
