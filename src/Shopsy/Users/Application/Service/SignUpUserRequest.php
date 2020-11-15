<?php


namespace App\Shopsy\Users\Application\Service;


use App\Shared\Application\Service\ApplicationRequest;

class SignUpUserRequest implements ApplicationRequest
{
    /**
     * @var string
     */
    public $fullName;

    /**
     * @var string
     */
    public $username;

    /**
     * @var string
     */
    public $email;

    /**
     * @var string
     */
    public $password;

    /**
     * SignUpUserRequest constructor.
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
}