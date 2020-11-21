<?php


namespace App\Shopsy\IdentityAccess\Infrastructure\Delivery\Api\Symfony\Dto;


use App\Shopsy\IdentityAccess\Infrastructure\Delivery\Api\Symfony\ParamConverter\JsonBodySerializableInterface;
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