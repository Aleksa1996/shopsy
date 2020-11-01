<?php


namespace App\Shared\Infrastructure\Application\Service;


use App\Shared\Application\Service\TransactionalSession;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Throwable;

class DoctrineSession implements TransactionalSession
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @inheritDoc
     *
     * @throws Throwable
     */
    public function executeAtomically(callable $operation)
    {
        return $this->entityManager->transactional($operation);
    }
}