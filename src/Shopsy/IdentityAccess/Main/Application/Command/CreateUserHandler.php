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
use App\Shopsy\IdentityAccess\Main\Domain\Service\PasswordHasher;

class CreateUserHandler implements CommandHandler
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @var PasswordHasher
     */
    private $passwordHasher;

    /**
     * CreateUserHandler constructor.
     *
     * @param UserRepository $userRepository
     * @param PasswordHasher $passwordHasher
     */
    public function __construct(UserRepository $userRepository, PasswordHasher $passwordHasher)
    {
        $this->userRepository = $userRepository;
        $this->passwordHasher = $passwordHasher;
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
            new UserPassword($this->passwordHasher->hash($command->getPassword()))
        );

        $validationHandler = new ValidationNotificationHandler();
        $user->validate($validationHandler, $this->userRepository);

        if ($validationHandler->hasErrors()) {
            throw CommandException::createFromValidationNotificationHandler($validationHandler);
        }

        $this->userRepository->add($user);
    }
}
