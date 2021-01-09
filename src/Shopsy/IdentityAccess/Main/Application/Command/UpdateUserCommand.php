<?php

namespace App\Shopsy\IdentityAccess\Main\Application\Command;

use App\Common\Application\Command\Command;

class UpdateUserCommand implements Command
{
    /**
     * @var string|int
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
     * @var string
     */
    private $password;

    /**
     * @var string
     */
    private $active;

    /**
     * @var string
     */
    private $avatar;

    /**
     * UpdateUserCommand constructor.
     *
     * @param $fullName
     * @param $username
     * @param $email
     * @param $password
     * @param $active
     * @param $avatar
     */
    public function __construct($id, $fullName, $username, $email, $password, $active, $avatar = null)
    {
        $this->id = $id;
        $this->fullName = $fullName;
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
        $this->active = $active;
        $this->avatar = $avatar;
    }

    /**
     * Get the value of id
     *
     * @return  string|int
     */
    public function getId()
    {
        return $this->id;
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

    /**
     * Get the value of active
     *
     * @return  string
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Get the value of avatar
     *
     * @return  string
     */
    public function getAvatar()
    {
        return $this->avatar;
    }
}
