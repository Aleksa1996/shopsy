<?php

namespace App\Shopsy\IdentityAccess\Main\Application\Command;

use App\Common\Application\Command\CommandHandler;
use App\Common\Infrastructure\Service\Hasher\Hasher;
use App\Common\Domain\Validator\ValidationNotificationHandler;
use App\Shopsy\IdentityAccess\Main\Domain\Model\Identity\UserId;
use App\Shopsy\IdentityAccess\Main\Domain\Model\Identity\UserEmail;
use App\Shopsy\IdentityAccess\Main\Domain\Model\Identity\UserActive;
use App\Shopsy\IdentityAccess\Main\Domain\Model\Identity\UserFullName;
use App\Shopsy\IdentityAccess\Main\Domain\Model\Identity\UserPassword;
use App\Shopsy\IdentityAccess\Main\Domain\Model\Identity\UserUsername;
use App\Shopsy\IdentityAccess\Main\Domain\Model\Identity\UserRepository;
use App\Shopsy\IdentityAccess\Main\Application\Command\UpdateUserCommand;
use App\Shopsy\IdentityAccess\Main\Application\Exception\Command\UserNotFoundCommandException;
use App\Shopsy\IdentityAccess\Main\Application\Exception\Command\ValidationErrorCommandException;
use App\Shopsy\IdentityAccess\Main\Domain\Model\Identity\UserAvatar;

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

        if ($command->getActive() !== null)
            $user->setActive(new UserActive($command->getActive()));

        if ($command->getAvatar() !== null)
            $user->setAvatar(new UserAvatar($command->getAvatar()));

        $validationHandler = new ValidationNotificationHandler();
        $user->validate(
            $validationHandler,
            $this->userRepository
        );

        if ($validationHandler->hasErrors()) {
            throw ValidationErrorCommandException::createFromValidationNotificationHandler($validationHandler);
        }
    }
}
