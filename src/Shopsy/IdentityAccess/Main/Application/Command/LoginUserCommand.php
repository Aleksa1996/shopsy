<?php

namespace App\Shopsy\IdentityAccess\Main\Application\Command;

use App\Common\Application\Command\Command;

class LoginUserCommand implements Command
{
    /**
     * @var int|string
     */
    private $identity;

    /**
     * @var string
     */
    private $password;

    /**
     * LoginUserCommand constructor.
     *
     * @param int|string $identity
     * @param string $password
     */
    public function __construct($identity, $password = null)
    {
        $this->identity = $identity;
        $this->password = $password;
    }

    /**
     * @return  int|string
     */
    public function getIdentity()
    {
        return $this->identity;
    }

    /**
     * @return  string
     */
    public function getPassword()
    {
        return $this->password;
    }
}
