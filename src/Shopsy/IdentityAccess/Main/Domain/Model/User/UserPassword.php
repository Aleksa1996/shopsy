<?php

namespace App\Shopsy\IdentityAccess\Main\Domain\Model\User;

use App\Common\Domain\Assert\Assert;

class UserPassword
{
    /**
     * Password
     *
     * @var string
     */
    private $password;

    /**
     * Constructor
     *
     * @param $password
     */
    public function __construct($password)
    {
        Assert::that($password)
            ->notEmpty('User password is empty.');

        $this->password = $password;
    }

    /**
     * Get password
     *
     * @return  string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * To string
     *
     * @return string
     */
    public function __toString()
    {
        return $this->getPassword();
    }
}
