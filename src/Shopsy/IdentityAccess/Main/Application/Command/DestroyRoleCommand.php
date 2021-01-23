<?php

namespace App\Shopsy\IdentityAccess\Main\Application\Command;

class DestroyRoleCommand
{
    /**
     * @var int|string
     */
    private $id;

    /**
     * DestroyRoleCommand constructor.
     *
     * @param $id
     */
    public function __construct($id)
    {
        $this->id = $id;
    }

    /**
     * @return  int|string
     */
    public function getId()
    {
        return $this->id;
    }
}
