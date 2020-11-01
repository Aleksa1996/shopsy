<?php


namespace App\Shopsy\Users\Infrastructure\Persistence\Doctrine;


use App\Shopsy\Users\Domain\Model\User;
use App\Shopsy\Users\Domain\Model\UserEmail;
use App\Shopsy\Users\Domain\Model\UserId;
use App\Shopsy\Users\Domain\Model\UserRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

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
     */
    public function nextIdentity()
    {
        return new UserId();
    }
}