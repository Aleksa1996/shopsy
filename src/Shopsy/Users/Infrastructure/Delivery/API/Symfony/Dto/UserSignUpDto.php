<?php


namespace App\Shopsy\Users\Infrastructure\Delivery\API\Symfony\Dto;


use App\Shopsy\Users\Infrastructure\Delivery\API\Symfony\ParamConverter\JsonBodySerializableInterface;
use Symfony\Component\Validator\Constraints as Assert;

class UserSignUpDto implements JsonBodySerializableInterface
{
    /**
     * @Assert\NotBlank
     */
    public $fullName;

    /**
     * @Assert\NotBlank
     */
    public $username;

    /**
     * @Assert\NotBlank
     */
    public $email;

    /**
     * @Assert\NotBlank
     */
    public $password;
}