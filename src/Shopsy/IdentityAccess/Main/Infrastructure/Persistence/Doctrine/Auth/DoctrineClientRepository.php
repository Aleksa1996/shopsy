<?php

namespace App\Shopsy\IdentityAccess\Main\Infrastructure\Persistence\Doctrine\Auth;

use App\Common\Domain\Id;
use Doctrine\Persistence\ManagerRegistry;
use App\Shopsy\IdentityAccess\Main\Domain\Model\Auth\Client;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use App\Shopsy\IdentityAccess\Main\Domain\Model\Auth\ClientRepository;

class DoctrineClientRepository extends ServiceEntityRepository implements ClientRepository
{
    /**
     * ClientRepository constructor.
     *
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Client::class);
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
    public function findByGeneralPurposeAuthentication()
    {
        return $this
            ->createQueryBuilder('c')
            ->where('c.usedForGeneralPurposeAuthentication = true')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * @inheritDoc
     *
     * @throws ORMException
     */
    public function add(Client $client)
    {
        $this->getEntityManager()->persist($client);
    }

    /**
     * @inheritDoc
     *
     * @throws ORMException
     */
    public function remove(Client $client)
    {
        $this->getEntityManager()->remove($client);
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
