<?php

namespace App\Shopsy\IdentityAccess\Application\Command;

use App\Common\Application\Command\CommandHandler;
use App\Shopsy\IdentityAccess\Application\Command\DestroyUserCommand;
use App\Shopsy\IdentityAccess\Domain\Model\User\UserId;
use App\Shopsy\IdentityAccess\Domain\Model\User\UserRepository;

class DestroyUserHandler implements CommandHandler
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * DestroyUserHandler constructor.
     *
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @inheritDoc
     */
    public function execute(DestroyUserCommand $command = null)
    {
        $user = $this->userRepository->findById(new UserId($command->getId()));

        $this->userRepository->remove($user);
    }
}
