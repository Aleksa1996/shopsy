<?php

namespace App\Shopsy\IdentityAccess\Main\Application\Query;

use App\Common\Application\Query\QueryHandler;
use App\Shopsy\IdentityAccess\Main\Domain\UserQueryFactory;
use App\Shopsy\IdentityAccess\Main\Application\Query\UserQuery;
use App\Shopsy\IdentityAccess\Main\Domain\Model\User\UserRepository;
use App\Shopsy\IdentityAccess\Main\Application\Transformer\UserTransformer;

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
        $repositoryQueryResult = null;

        if ($query->getId()) {
            $repositoryQueryResult = $this->userRepository->query(
                $this->userQueryFactory->id($query->getId())
            );
        }

        // if ($query->getFullName()) {
        // }

        // if ($query->getUsername()) {
        //     $user = $this->userRepository->query(
        //         $this->userQueryFactory->username($query->getUsername())
        //     );
        // }

        // if ($query->getFullName()) {
        // }

        if (empty($repositoryQueryResult->getData())) {
            //TODO: throw not found
        }

        $this->userTransformer->write($repositoryQueryResult->getData());
        return $this->userTransformer->read();
    }
}
