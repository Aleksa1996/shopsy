<?php


namespace App\Shopsy\Users\Application\Service;


use App\Shared\Application\Service\ApplicationRequest;

class SignInUserRequest implements ApplicationRequest
{
    /**
     * @var string
     */
    public $email;

    /**
     * @var string
     */
    public $password;

    /**
     * SignInUserRequest constructor.
     *
     * @param $email
     * @param $password
     */
    public function __construct($email, $password)
    {
        $this->email = $email;
        $this->password = $password;
    }
}