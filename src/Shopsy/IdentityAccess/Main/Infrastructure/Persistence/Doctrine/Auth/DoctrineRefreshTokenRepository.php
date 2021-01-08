<?php

namespace App\Shopsy\IdentityAccess\Main\Infrastructure\Persistence\Doctrine\Auth;

use App\Common\Domain\Id;
use Doctrine\Persistence\ManagerRegistry;
use App\Shopsy\IdentityAccess\Main\Domain\Model\Auth\RefreshToken;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use App\Shopsy\IdentityAccess\Main\Domain\Model\Auth\RefreshTokenRepository;

class DoctrineRefreshTokenRepository extends ServiceEntityRepository implements RefreshTokenRepository
{
    /**
     * RefreshTokenRepository constructor.
     *
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RefreshToken::class);
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
     */
    public function findByIdentifier(string $id)
    {
        return $this
            ->createQueryBuilder('rt')
            ->where('rt.identifier = :identifier')
            ->setParameter('identifier', $id)
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * @inheritDoc
     *
     * @throws ORMException
     */
    public function add(RefreshToken $refreshToken)
    {
        $this->getEntityManager()->persist($refreshToken);
    }

    /**
     * @inheritDoc
     *
     * @throws ORMException
     */
    public function remove(RefreshToken $refreshToken)
    {
        $this->getEntityManager()->remove($refreshToken);
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
