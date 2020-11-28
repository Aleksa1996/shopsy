<?php

namespace App\Shopsy\IdentityAccess\Application\Query;

use App\Common\Application\Query\QueryHandler;
use App\Shopsy\IdentityAccess\Domain\UserQueryFactory;
use App\Shopsy\IdentityAccess\Application\Query\UserQuery;
use App\Shopsy\IdentityAccess\Domain\Model\User\UserRepository;
use App\Shopsy\IdentityAccess\Application\Transformer\UserTransformer;

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
        if ($query->getFullName()) {
        }

        $user = null;
        if ($query->getUsername()) {
            $user = $this->userRepository->query(
                $this->userQueryFactory->username($query->getUsername())
            );
        }

        if ($query->getFullName()) {
        }

        if (empty($user)) {
            //TODO: throw not found
        }

        $this->userTransformer->write($user);
        return $this->userTransformer->read();
    }
}
