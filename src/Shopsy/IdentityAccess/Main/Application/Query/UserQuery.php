<?php

namespace App\Shopsy\IdentityAccess\Main\Application\Query;

use App\Common\Application\Query\Query;

class UserQuery implements Query
{
    /**
     * @var int|string
     */
    private $id;

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
    public function __construct($id, $fullName = null, $username = null, $email = null)
    {
        $this->id = $id;
        $this->fullName = $fullName;
        $this->username = $username;
        $this->email = $email;
    }

    /**
     * @return  int|string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return  string
     */
    public function getFullName()
    {
        return $this->fullName;
    }

    /**
     * @return  string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @return  string
     */
    public function getEmail()
    {
        return $this->email;
    }
}
