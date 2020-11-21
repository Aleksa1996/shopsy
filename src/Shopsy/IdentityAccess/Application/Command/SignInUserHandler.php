<?php


namespace App\Shopsy\IdentityAccess\Application\Command;


use App\Common\Application\Command\CommandHandler;
use App\Shopsy\IdentityAccess\Application\DataTransformer\UserDataTransformer;
use App\Shopsy\IdentityAccess\Domain\Model\Authentication;
use App\Shopsy\IdentityAccess\Domain\Model\UserEmail;
use App\Shopsy\IdentityAccess\Domain\Model\UserNotExistsException;
use App\Shopsy\IdentityAccess\Domain\Model\UserPassword;

class SignInUserHandler implements CommandHandler
{

    /**
     * @var Authentication
     */
    private $authentication;

    /**
     * @var UserDataTransformer
     */
    private $userDataTransformer;

    public function __construct(Authentication $authentication, UserDataTransformer $userDataTransformer)
    {
        $this->authentication = $authentication;
        $this->userDataTransformer = $userDataTransformer;
    }

    /**
     * @inheritDoc
     *
     * @throws UserNotExistsException
     */
    public function execute(SignInUserCommand $command = null)
    {
        $data = $this->authentication->authenticate(
            new UserEmail($command->getEmail()),
            new UserPassword($command->getPassword())
        );
    }
}