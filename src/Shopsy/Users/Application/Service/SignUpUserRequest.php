<?php


namespace App\Shopsy\Users\Application\Service;


use App\Shared\Application\Service\ApplicationRequest;

class SignUpUserRequest implements ApplicationRequest
{
    /**
     * @var string
     */
    public $firstName;

    /**
     * @var string
     */
    public $lastName;

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
     * @param $firstName
     * @param $lastName
     * @param $email
     * @param $password
     */
    public function __construct($firstName, $lastName, $email, $password)
    {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->password = $password;
    }
}