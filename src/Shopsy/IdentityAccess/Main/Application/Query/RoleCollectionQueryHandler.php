<?php

namespace App\Shopsy\IdentityAccess\Main\Application\Query;

use App\Common\Application\Query\Sort;
use App\Common\Application\Query\Pagination;
use App\Common\Application\Query\QueryHandler;
use App\Common\Application\Query\Dto\DtoCollection;
use App\Common\Application\Query\PaginationResponse;
use App\Shopsy\IdentityAccess\Main\Domain\RoleQueryFactory;
use App\Shopsy\IdentityAccess\Main\Domain\Model\Access\RoleRepository;
use App\Shopsy\IdentityAccess\Main\Domain\Service\Access\Authorization;
use App\Shopsy\IdentityAccess\Main\Application\Query\RoleCollectionQuery;
use App\Shopsy\IdentityAccess\Main\Application\Transformer\RoleCollectionTransformer;

class RoleCollectionQueryHandler implements QueryHandler
{
    /**
     * @var RoleRepository
     */
    private $roleRepository;

    /**
     * @var RoleCollectionTransformer
     */
    private $roleCollectionTransformer;

    /**
     * @var RoleQueryFactory
     */
    private $roleQueryFactory;

    /**
     * @var Authorization
     */
    private $authorization;

    /**
     * RoleCollectionQueryHandler constructor.
     *
     * @param RoleRepository $roleRepository
     * @param RoleCollectionTransformer $roleCollectionTransformer
     * @param RoleQueryFactory $roleQueryFactory
     * @param Authorization $authorization
     */
    public function __construct(RoleRepository $roleRepository, RoleCollectionTransformer $roleCollectionTransformer, RoleQueryFactory $roleQueryFactory, Authorization $authorization)
    {
        $this->roleRepository = $roleRepository;
        $this->roleCollectionTransformer = $roleCollectionTransformer;
        $this->roleQueryFactory = $roleQueryFactory;
        $this->authorization = $authorization;
    }

    /**
     * @inheritDoc
     */
    public function execute(RoleCollectionQuery $query = null)
    {
        // if (!$this->authorization->authorize(RolePermission::LIST_ACTION, Role::class)) {
        //     throw new UserPermissionDeniedException();
        // }

        $pagination = new Pagination($query->getPage(), $query->getLimit());
        $sort = Sort::create($query->getSort());

        $repositoryQueryResult = $this->roleRepository->query(
            $this->roleQueryFactory->filterCollection($query->getFilter() ?? [], $pagination, $sort)
        );

        $this->roleCollectionTransformer->write(
            $repositoryQueryResult->getData()
        );

        return new DtoCollection(
            $this->roleCollectionTransformer->read(),
            new PaginationResponse($repositoryQueryResult->getCount(), $pagination->getPage(), $pagination->getLimit())
        );
    }
}
