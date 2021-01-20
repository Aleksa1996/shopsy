<?php

namespace App\Shopsy\IdentityAccess\Main\Application\Dto;

use App\Common\Application\Query\Dto\Dto;

class RoleDto extends Dto
{
    /**
     * @var int|string
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $identifier;

    /**
     * @var string
     */
    private $permissions;

    /**
     * @var string
     */
    private $createdOn;

    /**
     * @var string
     */
    private $updatedOn;

    /**
     * RoleDto Constructor
     *
     * @param int|string $id
     * @param string $name
     * @param string $identifier
     * @param string $permissions
     * @param string $createdOn
     * @param string $updatedOn
     */
    public function __construct($id, $name, $identifier, $permissions, $createdOn, $updatedOn)
    {
        $this->id = $id;
        $this->name = $name;
        $this->identifier = $identifier;
        $this->permissions = $permissions;
        $this->createdOn = $createdOn;
        $this->updatedOn = $updatedOn;
    }

    /**
     * @return  int|string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return  string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return  string
     */
    public function getIdentifier()
    {
        return $this->identifier;
    }

    /**
     * @return  string
     */
    public function getPermissions()
    {
        return $this->permissions;
    }

    /**
     * @return  string
     */
    public function getCreatedOn()
    {
        return $this->createdOn;
    }

    /**
     * @return  string
     */
    public function getUpdatedOn()
    {
        return $this->updatedOn;
    }
}
