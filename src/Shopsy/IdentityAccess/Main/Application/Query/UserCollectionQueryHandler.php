<?php

namespace App\Shopsy\IdentityAccess\Main\Application\Query;

use App\Common\Application\Query\Sort;
use App\Common\Application\Query\Pagination;
use App\Common\Application\Query\QueryHandler;
use App\Common\Application\Query\Dto\DtoCollection;
use App\Common\Application\Query\PaginationResponse;
use App\Shopsy\IdentityAccess\Main\Domain\UserQueryFactory;
use App\Shopsy\IdentityAccess\Main\Domain\Model\Identity\User;
use App\Shopsy\IdentityAccess\Main\Domain\Model\Access\RolePermission;
use App\Shopsy\IdentityAccess\Main\Domain\Service\Access\Authorization;
use App\Shopsy\IdentityAccess\Main\Domain\Model\Identity\UserRepository;
use App\Shopsy\IdentityAccess\Main\Application\Transformer\UserCollectionTransformer;
use App\Shopsy\IdentityAccess\Main\Application\Exception\Query\UnauthorizedQueryException;

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
     * @var Authorization
     */
    private $authorization;

    /**
     * UserCollectionQueryHandler constructor.
     *
     * @param UserRepository $userRepository
     * @param UserQueryFactory $userQueryFactory
     * @param UserCollectionTransformer $userCollectionTransformer
     */
    public function __construct(UserRepository $userRepository, UserQueryFactory $userQueryFactory, UserCollectionTransformer $userCollectionTransformer, Authorization $authorization)
    {
        $this->userRepository = $userRepository;
        $this->userQueryFactory = $userQueryFactory;
        $this->userCollectionTransformer = $userCollectionTransformer;
        $this->authorization = $authorization;
    }

    /**
     * @inheritDoc
     */
    public function execute(UserCollectionQuery $query = null)
    {
        if (!$this->authorization->authorize(RolePermission::LIST_ACTION, User::class)) {
            throw new UnauthorizedQueryException();
        }

        $pagination = new Pagination($query->getPage(), $query->getLimit());
        $sort = Sort::create($query->getSort());

        $repositoryQueryResult = $this->userRepository->query(
            $this->userQueryFactory->filterCollection($query->getFilter() ?? [], $pagination, $sort)
        );

        $this->userCollectionTransformer->write(
            $repositoryQueryResult->getData()
        );

        return new DtoCollection(
            $this->userCollectionTransformer->read(),
            new PaginationResponse($repositoryQueryResult->getCount(), $pagination->getPage(), $pagination->getLimit())
        );
    }
}
