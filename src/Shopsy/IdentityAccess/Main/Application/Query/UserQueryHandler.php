<?php

namespace App\Shopsy\IdentityAccess\Main\Application\Query;

use App\Common\Application\Query\Sort;
use App\Common\Application\Query\QueryHandler;
use App\Shopsy\IdentityAccess\Main\Domain\UserQueryFactory;
use App\Shopsy\IdentityAccess\Main\Application\Query\UserQuery;
use App\Shopsy\IdentityAccess\Main\Domain\Model\Identity\UserRepository;
use App\Shopsy\IdentityAccess\Main\Application\Transformer\UserTransformer;
use App\Shopsy\IdentityAccess\Main\Application\Exception\Query\UserNotFoundQueryException;

class UserQueryHandler implements QueryHandler
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
     * @var UserTransformer
     */
    private $userTransformer;

    /**
     * UserQueryHandler constructor.
     *
     * @param UserRepository $userRepository
     * @param UserQueryFactory $userQueryFactory
     * @param UserTransformer $userTransformer
     */
    public function __construct(UserRepository $userRepository, UserQueryFactory $userQueryFactory, UserTransformer $userTransformer)
    {
        $this->userRepository = $userRepository;
        $this->userQueryFactory = $userQueryFactory;
        $this->userTransformer = $userTransformer;
    }

    /**
     * @inheritDoc
     */
    public function execute(UserQuery $query = null)
    {
        $sort = Sort::create($query->getSort());

        $repositoryQueryResult = $this->userRepository->query(
            $this->userQueryFactory->filter($query->getFilter() ?? [], $sort)
        );

        if (!$repositoryQueryResult || empty($repositoryQueryResult->getData())) {
            throw new UserNotFoundQueryException();
        }

        $this->userTransformer->write($repositoryQueryResult->getData());
        return $this->userTransformer->read();
    }
}
