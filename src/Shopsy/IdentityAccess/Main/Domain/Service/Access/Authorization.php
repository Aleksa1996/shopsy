<?php

namespace App\Shopsy\IdentityAccess\Main\Domain\Service\Access;

use App\Common\Domain\Event\Facade\DomainEventPublisher;
use App\Shopsy\IdentityAccess\Main\Domain\Event\AuthorizationAttempted;
use App\Shopsy\IdentityAccess\Main\Domain\Event\AuthorizationFailed;
use App\Shopsy\IdentityAccess\Main\Domain\Event\AuthorizationSucceed;

abstract class Authorization
{
    /**
     * @param mixed $attribute
     * @param mixed $subject
     *
     * @return bool
     */
    public function authorize($attribute, $subject = null)
    {
        DomainEventPublisher::instance()
            ->publish(
                new AuthorizationAttempted($attribute, $subject)
            );

        $response = $this->respondToAuthorizeCall($attribute, $subject);

        $event = null;
        if ($response) {
            $event = new AuthorizationSucceed($attribute, $subject);
        } else {
            $event = new AuthorizationFailed($attribute, $subject);
        }

        DomainEventPublisher::instance()->publish($event);

        return $response;
    }

    /**
     * @param mixed $attribute
     * @param mixed $subject
     *
     * @return AuthenticateResponse
     */
    abstract protected function respondToAuthorizeCall($attribute, $subject = null);
}
