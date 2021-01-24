<?php

namespace App\Shopsy\IdentityAccess\Main\Domain\Model\Identity;

use App\Common\Domain\Assert\Assert;


class UserAvatar
{
    /**
     * @var string
     */
    private $avatar;

    /**
     * UserAvatar Constructor
     *
     * @param string $avatar
     */
    public function __construct(string $avatar)
    {
        Assert::that($avatar)
            ->notEmpty('User avatar field is empty.')
            ->string('User avatar field must be string.');

        $this->avatar = $avatar;
    }

    /**
     * @return  string
     */
    public function getAvatar()
    {
        return $this->avatar;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getAvatar();
    }
}
