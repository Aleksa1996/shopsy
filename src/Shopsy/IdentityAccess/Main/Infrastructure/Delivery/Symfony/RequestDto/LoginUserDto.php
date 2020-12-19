<?php

namespace App\Shopsy\IdentityAccess\Main\Infrastructure\Delivery\Symfony\RequestDto;

use App\Common\Infrastructure\Delivery\Symfony\RequestDto\RequestDto;
use OpenApi\Annotations as OA;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @OA\Schema(
 *      schema="login_user_dto",
 *      title="User model",
 *      description="User model",
 * )
 */
class LoginUserDto implements RequestDto
{
    /**
     * @Assert\NotBlank
     * @Assert\Length(
     *      min = 4,
     *      max = 300,
     *      minMessage = "Username must be at least {{ limit }} characters long.",
     *      maxMessage = "Username cannot be longer than {{ limit }} characters.",
     *      allowEmptyString = false
     * )
     * @OA\Property(
     *      type="string",
     *      title="Username",
     *      description="Username of user"
     * )
     */
    public $username;

    /**
     * @Assert\NotBlank
     * @Assert\Length(
     *      min = 5,
     *      max = 35,
     *      minMessage = "Password must be at least {{ limit }} characters long.",
     *      maxMessage = "Password cannot be longer than {{ limit }} characters.",
     *      allowEmptyString = false
     * )
     * @OA\Property(
     *      type="string",
     *      title="Password",
     *      description="Password of user"
     * )
     */
    public $password;
}
