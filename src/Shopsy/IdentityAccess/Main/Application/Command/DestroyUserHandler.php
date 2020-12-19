<?php

namespace App\Shopsy\IdentityAccess\Main\Application\Command;

use App\Common\Application\Command\CommandHandler;
use App\Shopsy\IdentityAccess\Main\Domain\Model\Identity\UserId;
use App\Shopsy\IdentityAccess\Main\Domain\Model\Identity\UserRepository;
use App\Shopsy\IdentityAccess\Main\Application\Command\DestroyUserCommand;
use App\Shopsy\IdentityAccess\Main\Application\Exception\Command\UserNotFoundCommandException;

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

        if (!$user) {
            throw new UserNotFoundCommandException();
        }

        $this->userRepository->remove($user);
    }
}
