<?php

namespace App\Shopsy\IdentityAccess\Application\Command;

use App\Common\Application\Command\Command;

class CreateUserCommand implements Command
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
     * @var string
     */
    private $password;

    /**
     * CreateUserCommand constructor.
     *
     * @param $fullName
     * @param $username
     * @param $email
     * @param $password
     */
    public function __construct($fullName, $username, $email, $password)
    {
        $this->fullName = $fullName;
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
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

    /**
     * Get the value of password
     *
     * @return  string
     */
    public function getPassword()
    {
        return $this->password;
    }
}
