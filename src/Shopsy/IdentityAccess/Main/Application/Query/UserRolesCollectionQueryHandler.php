<?php

namespace App\Shopsy\IdentityAccess\Main\Application\Query;

use App\Common\Application\Query\Sort;
use App\Common\Application\Query\Pagination;
use App\Common\Application\Query\QueryHandler;
use App\Common\Application\Query\Dto\DtoCollection;
use App\Common\Application\Query\PaginationResponse;
use App\Shopsy\IdentityAccess\Main\Domain\RoleQueryFactory;
use App\Shopsy\IdentityAccess\Main\Domain\Model\Identity\UserId;
use App\Shopsy\IdentityAccess\Main\Domain\Service\Access\Authorization;
use App\Shopsy\IdentityAccess\Main\Domain\Model\Identity\UserRepository;
use App\Shopsy\IdentityAccess\Main\Application\Query\UserRolesCollectionQuery;
use App\Shopsy\IdentityAccess\Main\Application\Transformer\RoleCollectionTransformer;
use App\Shopsy\IdentityAccess\Main\Application\Exception\Query\UserNotFoundQueryException;

class UserRolesCollectionQueryHandler implements QueryHandler
{
    /**
     * @var UserRepository
     */
    private $userRepository;

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
     * UserRolesCollectionQueryHandler constructor.
     *
     * @param UserRepository $userRepository
     * @param RoleCollectionTransformer $roleCollectionTransformer
     * @param RoleQueryFactory $roleQueryFactory
     * @param Authorization $authorization
     */
    public function __construct(UserRepository $userRepository, RoleCollectionTransformer $roleCollectionTransformer, RoleQueryFactory $roleQueryFactory, Authorization $authorization)
    {
        $this->userRepository = $userRepository;
        $this->roleCollectionTransformer = $roleCollectionTransformer;
        $this->roleQueryFactory = $roleQueryFactory;
        $this->authorization = $authorization;
    }

    /**
     * @inheritDoc
     */
    public function execute(UserRolesCollectionQuery $query = null)
    {
        // if (!$this->authorization->authorize(RolePermission::LIST_ACTION, Role::class)) {
        //     throw new UserPermissionDeniedException();
        // }

        $user = $this->userRepository->findById(new UserId($query->getUserId()));

        if (!$user) {
            throw new UserNotFoundQueryException();
        }

        $pagination = new Pagination($query->getPage(), $query->getLimit());
        $sort = Sort::create($query->getSort());

        $criteria = $this->roleQueryFactory->filterCollection($query->getFilter() ?? [], $pagination, $sort)->toCriteria();
        $roles = $user->getRolesWithCriteria($criteria);

        $this->roleCollectionTransformer->write(
            $roles
        );

        return new DtoCollection(
            $this->roleCollectionTransformer->read(),
            new PaginationResponse($user->getRoleCountWithCriteria($criteria), $pagination->getPage(), $pagination->getLimit())
        );
    }
}
