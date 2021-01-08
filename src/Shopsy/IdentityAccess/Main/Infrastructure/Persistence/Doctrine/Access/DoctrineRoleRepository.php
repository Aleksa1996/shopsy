<?php

namespace App\Shopsy\IdentityAccess\Main\Infrastructure\Persistence\Doctrine\Access;

use App\Common\Domain\Id;
use Doctrine\Persistence\ManagerRegistry;
use App\Shopsy\IdentityAccess\Main\Domain\Model\Access\Role;
use App\Shopsy\IdentityAccess\Main\Domain\Model\Access\RoleRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

class DoctrineRoleRepository extends ServiceEntityRepository implements RoleRepository
{
    /**
     * DoctrineRoleRepository constructor.
     *
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Role::class);
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
            ->createQueryBuilder('r')
            ->where('r.identifier = :identifier')
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
    public function add(Role $role)
    {
        $this->getEntityManager()->persist($role);
    }

    /**
     * @inheritDoc
     *
     * @throws ORMException
     */
    public function remove(Role $role)
    {
        $this->getEntityManager()->remove($role);
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
        throw new \BadMethodCallException('Not implemented');
    }
}
