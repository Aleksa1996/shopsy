<?php

namespace App\Shopsy\IdentityAccess\Main\Infrastructure\Delivery\Symfony\Security\Voter;

use App\Shopsy\IdentityAccess\Main\Domain\Model\Identity\User;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class UserVoter extends Voter
{
    /**
     * @inheritDoc
     */
    protected function supports(string $attribute, $subject)
    {
        if ($subject instanceof User || $subject === User::class) {
            return true;
        }

        return false;
    }

    /**
     * @inheritDoc
     */
    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token)
    {
        var_dump($token->isAuthenticated());
        var_dump($token->getRoleNames());
        var_dump($token->getAttributes());
        dd($subject);

        return true;
    }
}
