<?php

namespace App\Shopsy\IdentityAccess\Main\Application\Command;

use App\Common\Application\Command\CommandException;
use App\Common\Application\Command\CommandHandler;
use App\Shopsy\IdentityAccess\Main\Domain\Model\Identity\User;
use App\Shopsy\IdentityAccess\Main\Domain\Model\Identity\UserEmail;
use App\Shopsy\IdentityAccess\Main\Domain\Model\Identity\UserFullName;
use App\Shopsy\IdentityAccess\Main\Domain\Model\Identity\UserPassword;
use App\Shopsy\IdentityAccess\Main\Domain\Model\Identity\UserUsername;
use App\Common\Domain\Validator\ValidationNotificationHandler;
use App\Shopsy\IdentityAccess\Main\Domain\Model\Identity\UserRepository;
use App\Common\Infrastructure\Service\Hasher\Hasher;

class CreateUserHandler implements CommandHandler
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
     * CreateUserHandler constructor.
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
    public function execute(CreateUserCommand $command = null)
    {
        $user = new User(
            $this->userRepository->nextIdentity(),
            new UserFullName($command->getFullName()),
            new UserUsername($command->getUsername()),
            new UserEmail($command->getEmail()),
            new UserPassword($this->hasher->hash($command->getPassword()))
        );

        $validationHandler = new ValidationNotificationHandler();
        $user->validate($validationHandler, $this->userRepository);

        if ($validationHandler->hasErrors()) {
            throw CommandException::createFromValidationNotificationHandler($validationHandler);
        }

        $this->userRepository->add($user);
    }
}
