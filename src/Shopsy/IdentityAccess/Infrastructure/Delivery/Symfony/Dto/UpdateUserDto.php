<?php

namespace App\Shopsy\IdentityAccess\Infrastructure\Delivery\Symfony\Dto;


use Symfony\Component\Validator\Constraints as Assert;
use App\Common\Infrastructure\Delivery\Symfony\ParamConverter\JsonBodySerializableInterface;

class UpdateUserDto implements JsonBodySerializableInterface
{
    /**
     * @Assert\NotBlank(allowNull=true)
     * @Assert\Length(
     *      min = 2,
     *      max = 200,
     *      minMessage = "Fullname must be at least {{ limit }} characters long.",
     *      maxMessage = "Fullname cannot be longer than {{ limit }} characters.",
     *      allowEmptyString = false
     * )
     */
    public $fullName;

    /**
     * @Assert\NotBlank(allowNull=true)
     * @Assert\Length(
     *      min = 4,
     *      max = 100,
     *      minMessage = "Username must be at least {{ limit }} characters long.",
     *      maxMessage = "Username cannot be longer than {{ limit }} characters.",
     *      allowEmptyString = false
     * )
     */
    public $username;

    /**
     * @Assert\NotBlank(allowNull=true)
     * @Assert\Email(
     *     message = "The email '{{ value }}' is not a valid email."
     * )
     */
    public $email;

    /**
     * @Assert\NotBlank(allowNull=true)
     * @Assert\Length(
     *      min = 5,
     *      max = 35,
     *      minMessage = "Password must be at least {{ limit }} characters long.",
     *      maxMessage = "Password cannot be longer than {{ limit }} characters.",
     *      allowEmptyString = false
     * )
     */
    public $password;
}
