<?php

namespace App\Shopsy\IdentityAccess\Main\Application\Command;

use App\Common\Application\Command\CommandHandler;
use App\Shopsy\IdentityAccess\Main\Domain\Service\Authentication;
use App\Shopsy\IdentityAccess\Main\Domain\Model\Identity\UserEmail;
use App\Shopsy\IdentityAccess\Main\Domain\Model\Identity\UserPassword;
use App\Shopsy\IdentityAccess\Main\Domain\Model\Identity\UserUsername;
use App\Shopsy\IdentityAccess\Main\Application\Exception\Command\UserLoginFailedException;
use App\Shopsy\IdentityAccess\Main\Application\Transformer\AuthenticationResponseTransformer;

class LoginUserHandler implements CommandHandler
{
    /**
     * @var Authentication
     */
    private $authentication;

    /**
     * @var AuthenticationResponseTransformer
     */
    private $authenticationResponseTransformer;

    /**
     * LoginUserHandler Constructor.
     *
     * @param Authentication $authentication
     */
    public function __construct(Authentication $authentication, AuthenticationResponseTransformer $authenticationResponseTransformer)
    {
        $this->authentication = $authentication;
        $this->authenticationResponseTransformer = $authenticationResponseTransformer;
    }

    /**
     * @inheritDoc
     */
    public function execute(LoginUserCommand $command = null)
    {
        $identity = null;
        try {
            $identity = new UserEmail($command->getIdentity());
        } catch (\Exception $e) {
            $identity = new UserUsername($command->getIdentity());
        }

        $userPassword = null;
        if ($command->getPassword()) {
            $userPassword = new UserPassword($command->getPassword());
        }

        $authenticationResponse = $this->authentication->authenticate(
            $identity,
            $userPassword
        );

        if (!$authenticationResponse->getSuccess()) {
            throw new UserLoginFailedException(
                'User login failed',
                $authenticationResponse->getMessage()
            );
        }

        $this->authenticationResponseTransformer->write($authenticationResponse);
        return $this->authenticationResponseTransformer->read();
    }
}
