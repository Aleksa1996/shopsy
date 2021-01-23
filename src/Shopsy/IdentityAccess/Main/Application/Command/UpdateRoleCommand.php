<?php

namespace App\Shopsy\IdentityAccess\Main\Application\Command;

use App\Common\Application\Command\Command;

class UpdateRoleCommand implements Command
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
     * UpdateRoleRequest constructor.
     *
     * @param $id
     * @param $name
     * @param $identifier
     * @param $permissions
     */
    public function __construct($id, $name, $identifier, $permissions)
    {
        $this->id = $id;
        $this->name = $name;
        $this->identifier = $identifier;
        $this->permissions = $permissions;
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
     * @return  array
     */
    public function getPermissions()
    {
        return $this->permissions;
    }
}
