<?php

namespace App\Shopsy\IdentityAccess\Main\Application\Command;

use App\Common\Application\Command\CommandHandler;
use App\Common\Application\Command\CommandException;
use App\Shopsy\IdentityAccess\Main\Domain\Model\Identity\UserId;
use App\Common\Domain\Validator\ValidationNotificationHandler;
use App\Shopsy\IdentityAccess\Main\Domain\Model\Identity\UserEmail;
use App\Common\Infrastructure\Service\Hasher\Hasher;
use App\Shopsy\IdentityAccess\Main\Domain\Model\Identity\UserFullName;
use App\Shopsy\IdentityAccess\Main\Domain\Model\Identity\UserPassword;
use App\Shopsy\IdentityAccess\Main\Domain\Model\Identity\UserUsername;
use App\Shopsy\IdentityAccess\Main\Domain\Model\Identity\UserRepository;
use App\Shopsy\IdentityAccess\Main\Application\Command\UpdateUserCommand;
use App\Shopsy\IdentityAccess\Main\Application\Exception\Command\UserNotFoundCommandException;

class UpdateUserHandler implements CommandHandler
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @var Hasher
     */
    private $hasher;

    /**
     * UpdateUserHandler constructor.
     *
     * @param UserRepository $userRepository
     * @param Hasher $hasher
     */
    public function __construct(UserRepository $userRepository, Hasher $hasher)
    {
        $this->userRepository = $userRepository;
        $this->hasher = $hasher;
    }

    /**
     * @inheritDoc
     */
    public function execute(UpdateUserCommand $command = null)
    {
        $user = $this->userRepository->findById(new UserId($command->getId()));

        if (!$user) {
            throw new UserNotFoundCommandException();
        }

        if ($command->getFullName())
            $user->setFullName(new UserFullName($command->getFullName()));

        if ($command->getUsername())
            $user->setUsername(new UserUsername($command->getUsername()));

        if ($command->getEmail())
            $user->setEmail(new UserEmail($command->getEmail()));

        if ($command->getPassword())
            $user->setPassword(new UserPassword($this->hasher->hash($command->getPassword())));

        $validationHandler = new ValidationNotificationHandler();
        $user->validate(
            $validationHandler,
            $this->userRepository
        );

        if ($validationHandler->hasErrors()) {
            throw CommandException::createFromValidationNotificationHandler($validationHandler);
        }
    }
}
