<?php


namespace App\Shopsy\IdentityAccess\Main\Infrastructure\Persistence\Doctrine;


use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;
use App\Common\Domain\RepositoryQueryResult;
use Doctrine\ORM\Tools\Pagination\Paginator;
use App\Shopsy\IdentityAccess\Main\Domain\Model\User\User;
use App\Shopsy\IdentityAccess\Main\Domain\Model\User\UserId;
use App\Shopsy\IdentityAccess\Main\Domain\Model\User\UserEmail;
use App\Shopsy\IdentityAccess\Main\Domain\Model\User\UserUsername;
use App\Shopsy\IdentityAccess\Main\Domain\Model\User\UserRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use App\Shopsy\IdentityAccess\Main\Infrastructure\Persistence\Doctrine\Query\DoctrineUserQuery;
use App\Shopsy\IdentityAccess\Main\Infrastructure\Persistence\Doctrine\Query\DoctrineUserCollectionQuery;

class DoctrineUserRepository extends ServiceEntityRepository implements UserRepository
{
    /**
     * DoctrineUserRepository constructor.
     *
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * @inheritDoc
     */
    public function findById(UserId $userId)
    {
        return $this->find($userId);
    }

    /**
     * @inheritDoc
     */
    public function findByUsername(UserUsername $username)
    {
        return $this->findOneBy(['username' => $username]);
    }

    /**
     * @inheritDoc
     */
    public function findByEmail(UserEmail $email)
    {
        return $this->findOneBy(['email' => $email]);
    }

    /**
     * @inheritDoc
     *
     * @throws ORMException
     */
    public function add(User $user)
    {
        $this->getEntityManager()->persist($user);
    }

    /**
     * @inheritDoc
     *
     * @throws ORMException
     */
    public function remove(User $user)
    {
        $this->getEntityManager()->remove($user);
    }

    /**
     * @inheritDoc
     */
    public function nextIdentity()
    {
        return new UserId();
    }

    /**
     * @inheritDoc
     */
    public function query($query)
    {
        $queryBuilder = $this->createQueryBuilder('u');
        $queryBuilder->addCriteria($query->toCriteria());

        if ($query instanceof DoctrineUserQuery) {
            $result = $queryBuilder->getQuery()->getOneOrNullResult();
            return new RepositoryQueryResult($result, $result ? 1 : 0);
        }

        if ($query instanceof DoctrineUserCollectionQuery && !is_null($query->getPagination())) {
            $paginator = new Paginator($queryBuilder);
            return new RepositoryQueryResult($paginator, count($paginator));
        }

        $result = $queryBuilder->getQuery()->getResult();
        return new RepositoryQueryResult($result, count($result));
    }
}
