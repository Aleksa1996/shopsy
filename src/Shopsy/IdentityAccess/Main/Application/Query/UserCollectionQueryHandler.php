<?php

namespace App\Shopsy\IdentityAccess\Main\Application\Query;

use App\Common\Application\Query\QueryHandler;
use App\Common\Infrastructure\Application\Query\Sort;
use App\Common\Infrastructure\Application\Query\Pagination;
use App\Shopsy\IdentityAccess\Main\Domain\UserQueryFactory;
use App\Common\Infrastructure\Application\Query\Dto\DtoCollection;
use App\Shopsy\IdentityAccess\Main\Domain\Model\User\UserRepository;
use App\Common\Infrastructure\Application\Query\TraversablePagination;
use App\Shopsy\IdentityAccess\Main\Application\Transformer\UserCollectionTransformer;

class UserCollectionQueryHandler implements QueryHandler
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @var UserQueryFactory
     */
    private $userQueryFactory;

    /**
     * @var UserCollectionTransformer
     */
    private $userCollectionTransformer;

    /**
     * UserCollectionQueryHandler constructor.
     *
     * @param UserRepository $userRepository
     * @param UserQueryFactory $userQueryFactory
     * @param UserCollectionTransformer $userCollectionTransformer
     */
    public function __construct(UserRepository $userRepository, UserQueryFactory $userQueryFactory, UserCollectionTransformer $userCollectionTransformer)
    {
        $this->userRepository = $userRepository;
        $this->userQueryFactory = $userQueryFactory;
        $this->userCollectionTransformer = $userCollectionTransformer;
    }

    /**
     * @inheritDoc
     */
    public function execute(UserCollectionQuery $query = null)
    {
        $pagination = new Pagination($query->getPage(), $query->getLimit());
        $sort = Sort::create($query->getSort());

        $repositoryQueryResult = $this->userRepository->query(
            $this->userQueryFactory->filter($query->getFilter() ?? [], $pagination, $sort)
        );

        $this->userCollectionTransformer->write(
            $repositoryQueryResult->getData()
        );

        return new DtoCollection(
            $this->userCollectionTransformer->read(),
            new TraversablePagination($repositoryQueryResult->getCount(), $pagination->getPage(), $pagination->getLimit())
        );
    }
}
