<?php

namespace App\Shopsy\IdentityAccess\Main\Application\Command;

use App\Common\Application\Command\CommandHandler;
use App\Shopsy\IdentityAccess\Main\Domain\Model\User\User;
use App\Shopsy\IdentityAccess\Main\Domain\Model\User\UserEmail;
use App\Shopsy\IdentityAccess\Main\Domain\Model\User\UserFullName;
use App\Shopsy\IdentityAccess\Main\Domain\Model\User\UserPassword;
use App\Shopsy\IdentityAccess\Main\Domain\Model\User\UserUsername;
use App\Common\Domain\Validator\ValidationNotificationHandler;
use App\Shopsy\IdentityAccess\Main\Domain\Model\User\UserRepository;
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
            // TODO: odavde treba da se throwuje greska sa ovim
            \var_dump($validationHandler->getErrors());
            exit;
        }

        $this->userRepository->add($user);
    }
}
