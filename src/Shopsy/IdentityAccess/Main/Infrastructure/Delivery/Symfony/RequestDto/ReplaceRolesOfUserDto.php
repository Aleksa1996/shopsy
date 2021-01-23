<?php

namespace App\Shopsy\IdentityAccess\Main\Infrastructure\Delivery\Symfony\RequestDto;

use App\Common\Infrastructure\Delivery\Symfony\RequestDto\RequestDto;
use OpenApi\Annotations as OA;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @OA\Schema(
 *      schema="update_user_roles_dto",
 *      title="Attaching/Detaching Role to User model",
 *      description="Attaching/Detaching Role to User model",
 * )
 */
class ReplaceRolesOfUserDto implements RequestDto
{
    /**
     * @Assert\Type("array")
     * @Assert\All({
     *      @Assert\Uuid
     * })
     * @OA\Property(
     *      type="array",
     *      @OA\Items(
     *          type="string",
     *      ),
     *      title="Id's",
     *      description="Array of role id's"
     * )
     */
    public $id;
}
