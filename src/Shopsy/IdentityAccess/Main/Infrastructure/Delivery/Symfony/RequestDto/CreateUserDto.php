<?php

namespace App\Shopsy\IdentityAccess\Main\Infrastructure\Delivery\Symfony\RequestDto;


use Symfony\Component\Validator\Constraints as Assert;
use App\Common\Infrastructure\Delivery\Symfony\RequestDto\RequestDto;

class CreateUserDto implements RequestDto
{
    /**
     * @Assert\NotBlank
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
     * @Assert\NotBlank
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
     * @Assert\NotBlank
     * @Assert\Email(
     *     message = "The email '{{ value }}' is not a valid email."
     * )
     */
    public $email;

    /**
     * @Assert\NotBlank
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
