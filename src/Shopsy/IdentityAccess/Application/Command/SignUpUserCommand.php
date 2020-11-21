<?php


namespace App\Shopsy\IdentityAccess\Application\Command;


use App\Common\Application\Command\Command;

class SignUpUserCommand implements Command
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
     * SignUpUserCommand constructor.
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
     * @return string
     */
    public function getFullName(): string
    {
        return $this->fullName;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }
}