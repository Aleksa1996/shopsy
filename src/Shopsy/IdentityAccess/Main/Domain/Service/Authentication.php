<?php


namespace App\Shopsy\IdentityAccess\Main\Domain\Service;

use App\Common\Domain\Event\DomainEventPublisher;
use App\Shopsy\IdentityAccess\Main\Domain\Event\LogInAttempted;
use App\Shopsy\IdentityAccess\Main\Domain\Model\Identity\UserEmail;
use App\Shopsy\IdentityAccess\Main\Domain\Model\Identity\UserId;
use App\Shopsy\IdentityAccess\Main\Domain\Model\Identity\UserPassword;
use App\Shopsy\IdentityAccess\Main\Domain\Model\Identity\UserUsername;

abstract class Authentication
{
    /**
     * @param mixed $identity
     * @param UserPassword $password
     *
     * @return AuthenticateResponse
     */
    public function authenticate($identity, $userPassword = null)
    {
        DomainEventPublisher::instance()
            ->publish(
                new LogInAttempted($identity)
            );

        // TODO: remove manually created value objects for password and username
        $response = null;
        $identity = new UserUsername($identity);
        $userPassword = new UserPassword($userPassword);

        if ($identity instanceof UserUsername && $userPassword) {
            $response = $this->authenticateByUsername($identity, $userPassword);
        }

        if ($identity instanceof UserEmail && $userPassword) {
            $response = $this->authenticateByEmail($identity, $userPassword);
        }

        if ($identity instanceof UserId && !$userPassword) {
            $response = $this->authenticateById($identity);
        }

        $event = null;
        if ($response->success()) {
            $event = new LogInAttempted($identity);
        } else {
            $event = new LogInAttempted($identity);
        }

        DomainEventPublisher::instance()->publish($event);

        return $response;
    }

    /**
     * @param UserUsername $userUsername
     * @param UserPassword $userPassword
     *
     * @return AuthenticateResponse
     */
    abstract protected function authenticateByUsername(UserUsername $userUsername, UserPassword $userPassword);

    /**
     * @param UserEmail $userEmail
     * @param UserPassword $userPassword
     *
     * @return AuthenticateResponse
     */
    abstract protected function authenticateByEmail(UserEmail $userEmail, UserPassword $userPassword);

    /**
     * @param UserId $userId
     *
     * @return AuthenticateResponse
     */
    abstract protected function authenticateById(UserId $userId);
}
