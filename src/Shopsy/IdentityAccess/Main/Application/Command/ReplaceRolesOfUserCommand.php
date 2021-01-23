<?php

namespace App\Shopsy\IdentityAccess\Main\Application\Command;

class ReplaceRolesOfUserCommand
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
     * ReplaceRolesOfUserCommand constructor.
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
