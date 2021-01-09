<?php

namespace App\Shopsy\IdentityAccess\Main\Domain\Model\Identity;

use App\Common\Domain\Assert\Assert;


class UserActive
{
    /**
     * @var bool
     */
    private $active;

    /**
     * UserActive Constructor
     *
     * @param bool $active
     */
    public function __construct(bool $active)
    {
        Assert::that($active)->boolean('User active field must be boolean.');

        $this->active = $active;
    }

    /**
     * @return  bool
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * @return bool
     */
    public function __toString()
    {
        return $this->getActive();
    }
}
