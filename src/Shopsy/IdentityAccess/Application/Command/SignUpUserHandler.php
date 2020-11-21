<?php


namespace App\Shopsy\IdentityAccess\Application\Command;


use App\Common\Application\Command\CommandHandler;
use App\Shopsy\IdentityAccess\Domain\Exception\UserEmailNotUniqueException;
use App\Shopsy\IdentityAccess\Domain\Exception\UserUsernameNotUniqueException;
use App\Shopsy\IdentityAccess\Domain\Model\User;
use App\Shopsy\IdentityAccess\Domain\Model\UserEmail;
use App\Shopsy\IdentityAccess\Domain\Model\UserFullName;
use App\Shopsy\IdentityAccess\Domain\Model\UserUsername;
use App\Shopsy\IdentityAccess\Domain\Model\UserPassword;
use App\Shopsy\IdentityAccess\Domain\Model\UserRepository;
use App\Shopsy\IdentityAccess\Domain\Service\PasswordHasher;

class SignUpUserHandler implements CommandHandler
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
     * SignUpUserHandler constructor.
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
     * @param SignUpUserCommand $command
     *
     * @throws UserEmailNotUniqueException
     * @throws UserUsernameNotUniqueException
     */
    public function execute(SignUpUserCommand $command)
    {
        $user = $this->userRepository->findByEmail(
            new UserEmail($command->getEmail())
        );

        if ($user !== null) {
            throw new UserEmailNotUniqueException();
        }

        $user = $this->userRepository->findByUsername(
            new UserUsername($command->getUsername())
        );

        if ($user !== null) {
            throw new UserUsernameNotUniqueException();
        }

        $user = new User(
            $this->userRepository->nextIdentity(),
            new UserFullName($command->getFullName()),
            new UserUsername($command->getUsername()),
            new UserEmail($command->getEmail()),
            new UserPassword($this->passwordHasher->hash($command->getPassword()))
        );

        $this->userRepository->add($user);
    }
}