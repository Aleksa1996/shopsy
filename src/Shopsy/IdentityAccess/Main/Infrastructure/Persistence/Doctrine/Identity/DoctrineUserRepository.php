<?php


namespace App\Shopsy\IdentityAccess\Main\Infrastructure\Persistence\Doctrine\Identity;


use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;
use App\Common\Domain\RepositoryQueryResult;
use Doctrine\ORM\Tools\Pagination\Paginator;
use App\Shopsy\IdentityAccess\Main\Domain\Model\Identity\User;
use App\Shopsy\IdentityAccess\Main\Domain\Model\Identity\UserId;
use App\Shopsy\IdentityAccess\Main\Domain\Model\Identity\UserEmail;
use App\Shopsy\IdentityAccess\Main\Domain\Model\Identity\UserUsername;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use App\Shopsy\IdentityAccess\Main\Domain\Model\Identity\UserRepository;
use App\Common\Infrastructure\Persistence\Doctrine\Query\DoctrineEntityQuery;
use App\Common\Infrastructure\Persistence\Doctrine\Query\DoctrineEntityCollectionQuery;

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
