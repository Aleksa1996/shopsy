<?php

namespace App\Shopsy\IdentityAccess\Application\Query;

use App\Common\Application\Query\Query;

class UserQuery implements Query
{
    /**
     * @var string
     */
    private $fullName;

    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $email;

    /**
     * UserQuery constructor.
     *
     * @param $fullName
     * @param $username
     * @param $email
     */
    public function __construct($fullName, $username = null, $email = null)
    {
        $this->fullName = $fullName;
        $this->username = $username;
        $this->email = $email;
    }

    /**
     * Get the value of fullName
     *
     * @return  string
     */
    public function getFullName()
    {
        return $this->fullName;
    }

    /**
     * Get the value of username
     *
     * @return  string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Get the value of email
     *
     * @return  string
     */
    public function getEmail()
    {
        return $this->email;
    }
}
