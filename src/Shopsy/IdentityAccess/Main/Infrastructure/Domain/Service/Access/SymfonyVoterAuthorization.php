<?php

namespace App\Shopsy\IdentityAccess\Main\Infrastructure\Domain\Service\Access;

use App\Shopsy\IdentityAccess\Main\Domain\Service\Access\Authorization;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class SymfonyVoterAuthorization extends Authorization
{
    /**
     * @var AuthorizationCheckerInterface
     */
    private $authorizationChecker;

    /**
     * SymfonyVoterAuthorization Constructor.
     *
     * @param AuthorizationCheckerInterface $authorizationChecker
     */
    public function __construct(AuthorizationCheckerInterface $authorizationChecker)
    {
        $this->authorizationChecker = $authorizationChecker;
    }

    /**
     * @inheritDoc
     */
    protected function respondToAuthorizeCall($attribute, $subject = null)
    {
        return $this->authorizationChecker->isGranted($attribute, $subject);
    }
}
