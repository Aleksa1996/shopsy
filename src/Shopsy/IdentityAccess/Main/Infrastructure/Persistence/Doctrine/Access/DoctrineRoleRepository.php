<?php

namespace App\Shopsy\IdentityAccess\Main\Infrastructure\Persistence\Doctrine\Access;

use App\Common\Domain\Id;
use Doctrine\Persistence\ManagerRegistry;
use App\Common\Domain\RepositoryQueryResult;
use Doctrine\ORM\Tools\Pagination\Paginator;
use App\Shopsy\IdentityAccess\Main\Domain\Model\Access\Role;
use App\Shopsy\IdentityAccess\Main\Domain\Model\Access\RoleRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use App\Common\Infrastructure\Persistence\Doctrine\Query\DoctrineEntityQuery;
use App\Common\Infrastructure\Persistence\Doctrine\Query\DoctrineEntityCollectionQuery;

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
     */
    public function findByName(string $name)
    {
        return $this
            ->createQueryBuilder('r')
            ->where('r.name = :name')
            ->setParameter('name', $name)
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
        $queryBuilder = $this->createQueryBuilder('r');
        $queryBuilder->addCriteria($query->toCriteria());

        if ($query instanceof DoctrineEntityQuery) {
            $result = $queryBuilder->getQuery()->getOneOrNullResult();
            return new RepositoryQueryResult($result, $result ? 1 : 0);
        }

        if ($query instanceof DoctrineEntityCollectionQuery && !is_null($query->getPagination())) {
            $paginator = new Paginator($queryBuilder);
            return new RepositoryQueryResult($paginator, count($paginator));
        }

        $result = $queryBuilder->getQuery()->getResult();
        return new RepositoryQueryResult($result, count($result));
    }
}
