<?php

namespace App\Shopsy\IdentityAccess\Main\Application\Query;

use App\Common\Application\Query\Sort;
use App\Common\Application\Query\QueryHandler;
use App\Shopsy\IdentityAccess\Main\Domain\RoleQueryFactory;
use App\Shopsy\IdentityAccess\Main\Application\Query\RoleQuery;
use App\Shopsy\IdentityAccess\Main\Domain\Model\Access\RoleRepository;
use App\Shopsy\IdentityAccess\Main\Application\Transformer\RoleTransformer;
use App\Shopsy\IdentityAccess\Main\Application\Exception\Query\RoleNotFoundQueryException;

class RoleQueryHandler implements QueryHandler
{
    /**
     * @var RoleRepository
     */
    private $roleRepository;

    /**
     * @var RoleTransformer
     */
    private $roleTransformer;

    /**
     * @var RoleQueryFactory
     */
    private $roleQueryFactory;

    /**
     * RoleQueryHandler constructor.
     *
     * @param RoleRepository $roleRepository
     * @param RoleTransformer $roleTransformer
     * @param RoleQueryFactory $roleQueryFactory
     */
    public function __construct(RoleRepository $roleRepository, RoleTransformer $roleTransformer, RoleQueryFactory $roleQueryFactory)
    {
        $this->roleRepository = $roleRepository;
        $this->roleTransformer = $roleTransformer;
        $this->roleQueryFactory = $roleQueryFactory;
    }

    /**
     * @inheritDoc
     */
    public function execute(RoleQuery $request = null)
    {
        $sort = Sort::create($request->getSort());

        $repositoryQueryResult = $this->roleRepository->query(
            $this->roleQueryFactory->filter($request->getFilter() ?? [], $sort)
        );

        if (!$repositoryQueryResult || empty($repositoryQueryResult->getData())) {
            throw new RoleNotFoundQueryException();
        }

        $this->roleTransformer->write($repositoryQueryResult->getData());

        return $this->roleTransformer->read();
    }
}
