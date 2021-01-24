<?php

namespace App\Common\Infrastructure\Persistence\Doctrine\Event;

use App\Common\Domain\Id;
use App\Common\Domain\Event\DomainEvent;
use Doctrine\Persistence\ManagerRegistry;
use App\Common\Domain\Event\StoredDomainEvent;
use Symfony\Component\Serializer\SerializerInterface;
use App\Common\Domain\Event\StoredDomainEventRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

class DoctrineStoredDomainEventRepository extends ServiceEntityRepository implements StoredDomainEventRepository
{
    /**
     * @var SerializerInterface
     */
    private $serializer;

    /**
     * DoctrineStoredDomainEventRepository constructor.
     *
     * @param ManagerRegistry $registry
     * @param SerializerInterface $serializer
     */
    public function __construct(ManagerRegistry $registry, SerializerInterface $serializer)
    {
        parent::__construct($registry, StoredDomainEvent::class);
        $this->serializer = $serializer;
    }

    /**
     * @inheritDoc
     */
    public function append(DomainEvent $domainEvent)
    {
        $storedEvent = new StoredDomainEvent(
            new Id(),
            get_class($domainEvent),
            $domainEvent->getOccurredOn(),
            $this->serializer->serialize($domainEvent, 'json')
        );
        $this->getEntityManager()->persist($storedEvent);
    }

    /**
     * @inheritDoc
     */
    public function allStoredEventsSince(Id $id)
    {
        $query = $this->createQueryBuilder('e');

        if ($id) {
            $query->where('e.id > :id');
            $query->setParameters(['id' => $id]);
        }

        $query->orderBy('e.id');

        return $query->getQuery()->getResult();
    }
}
