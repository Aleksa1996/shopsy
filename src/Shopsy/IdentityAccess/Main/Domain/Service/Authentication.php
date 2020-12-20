<?php


namespace App\Shopsy\IdentityAccess\Main\Domain\Service;

use App\Common\Domain\Event\DomainEventPublisher;
use App\Shopsy\IdentityAccess\Main\Domain\Event\LoginFailed;
use App\Shopsy\IdentityAccess\Main\Domain\Event\LoginSucceed;
use App\Shopsy\IdentityAccess\Main\Domain\Event\LoginAttempted;
use App\Shopsy\IdentityAccess\Main\Domain\Model\Identity\UserPassword;
use App\Shopsy\IdentityAccess\Main\Domain\Model\Auth\AuthenticationResponse;

abstract class Authentication
{
    /**
     * @param mixed $identity
     * @param UserPassword $password
     *
     * @return AuthenticationResponse
     */
    public function authenticate($identity, UserPassword $userPassword = null)
    {
        DomainEventPublisher::instance()
            ->publish(
                new LoginAttempted($identity)
            );

        $response = $this->respondToAuthenticateCall($identity, $userPassword);

        if (!$response) {
            throw new \InvalidArgumentException('Empty authentication response. Probably because identity is not one of these instances: UserUsername, UserEmail, UserId');
        }

        $event = null;
        if ($response->getSuccess()) {
            $event = new LoginSucceed($identity);
        } else {
            $event = new LoginFailed($identity);
        }

        DomainEventPublisher::instance()->publish($event);

        return $response;
    }

    /**
     * @param mixed $userUsername
     * @param mixed $userPassword
     *
     * @return AuthenticateResponse
     */
    abstract protected function respondToAuthenticateCall($identity, $password);
}
