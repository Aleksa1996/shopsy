<?php

namespace App\Shopsy\IdentityAccess\Main\Application\Command;

class DetachRolesFromUserCommand
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var array
     */
    private $roles;

    /**
     * DetachRolesFromUserCommand constructor.
     *
     * @param $id
     * @param $roles
     */
    public function __construct($id, $roles)
    {
        $this->id = $id;
        $this->roles = $roles;
    }

    /**
     * @return  string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return  array
     */
    public function getRoles()
    {
        return $this->roles;
    }
}
