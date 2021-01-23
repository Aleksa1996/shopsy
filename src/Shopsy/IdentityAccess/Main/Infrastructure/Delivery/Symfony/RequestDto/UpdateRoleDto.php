<?php

namespace App\Shopsy\IdentityAccess\Main\Infrastructure\Delivery\Symfony\RequestDto;

use App\Common\Infrastructure\Delivery\Symfony\RequestDto\RequestDto;
use OpenApi\Annotations as OA;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @OA\Schema(
 *      schema="update_role_dto",
 *      title="Role model",
 *      description="Role model",
 * )
 */
class UpdateRoleDto implements RequestDto
{
    /**
     * @Assert\NotBlank(allowNull=true)
     * @Assert\Length(
     *      min = 2,
     *      max = 200,
     *      minMessage = "Name must be at least {{ limit }} characters long.",
     *      maxMessage = "Name cannot be longer than {{ limit }} characters.",
     *      allowEmptyString = false
     * )
     * @OA\Property(
     *      type="string",
     *      title="Name",
     *      description="Name of role"
     * )
     */
    public $name;

    /**
     * @Assert\NotBlank(allowNull=true)
     * @Assert\Regex(
     *      pattern="/^ROLE_(.)+/",
     *      message="Identifier must start with ROLE_{role_name}"
     * )
     * @Assert\Regex(
     *      pattern="/^[A-Z\_\d]+$/",
     *      message="Identifier must be with all uppercase letters."
     * )
     * @Assert\Length(
     *      min = 2,
     *      max = 100,
     *      minMessage = "Identifier must be at least {{ limit }} characters long.",
     *      maxMessage = "Identifier cannot be longer than {{ limit }} characters.",
     *      allowEmptyString = false
     * )
     * @OA\Property(
     *      type="string",
     *      title="Identifier",
     *      description="Identifier of role"
     * )
     */
    public $identifier;
}
