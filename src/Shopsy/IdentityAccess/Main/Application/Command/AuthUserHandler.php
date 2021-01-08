<?php

namespace App\Shopsy\IdentityAccess\Main\Application\Command;

use App\Common\Application\Command\CommandHandler;
use App\Shopsy\IdentityAccess\Main\Application\Exception\Command\UserAuthFailedCommandException;
use App\Shopsy\IdentityAccess\Main\Domain\Model\Identity\UserEmail;
use App\Shopsy\IdentityAccess\Main\Domain\Model\Identity\UserPassword;
use App\Shopsy\IdentityAccess\Main\Domain\Model\Identity\UserUsername;
use App\Shopsy\IdentityAccess\Main\Domain\Service\Auth\Authentication;
use App\Shopsy\IdentityAccess\Main\Application\Transformer\AuthTransformer;

class AuthUserHandler implements CommandHandler
{
    /**
     * @var Authentication
     */
    private $authentication;

    /**
     * @var AuthTransformer
     */
    private $authenticationResponseTransformer;

    /**
     * AuthUserHandler Constructor.
     *
     * @param Authentication $authentication
     */
    public function __construct(Authentication $authentication, AuthTransformer $authenticationResponseTransformer)
    {
        $this->authentication = $authentication;
        $this->authenticationResponseTransformer = $authenticationResponseTransformer;
    }

    /**
     * @inheritDoc
     */
    public function execute(AuthUserCommand $command = null)
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
            throw new UserAuthFailedCommandException(
                'User auth failed',
                $authenticationResponse->getMessage()
            );
        }

        $this->authenticationResponseTransformer->write($authenticationResponse);
        return $this->authenticationResponseTransformer->read();
    }
}
