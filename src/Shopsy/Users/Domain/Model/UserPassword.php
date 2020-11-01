<?php

namespace App\Shopsy\Users\Domain\Model;

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
        $this->assertNotEmpty($password);
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
     * Assert not empty
     *
     * @param string password
     *
     * @return void
     */
    private function assertNotEmpty($password)
    {
        if (empty($password)) {
            throw new \InvalidArgumentException('Empty Password');
        }
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
