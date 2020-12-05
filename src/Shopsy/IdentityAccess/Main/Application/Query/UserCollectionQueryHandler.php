<?php

namespace App\Shopsy\IdentityAccess\Main\Application\Query;

use App\Common\Infrastructure\Application\Query\Pagination;
use App\Common\Application\Dto\DtoCollection;
use App\Common\Application\Query\QueryHandler;
use App\Shopsy\IdentityAccess\Main\Domain\UserQueryFactory;
use App\Shopsy\IdentityAccess\Main\Domain\Model\User\UserRepository;
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

        if ($query->getFullName()) {
        }


        if ($query->getUsername()) {
        }

        if ($query->getFullName()) {
        }

        $users = $this->userRepository->query(
            $this->userQueryFactory->all($pagination)
        );

        $this->userCollectionTransformer->write($users);

        return new DtoCollection(
            $this->userCollectionTransformer->read(),
            count($users),
            $pagination->getPage(),
            $pagination->getLimit()
        );
    }
}
