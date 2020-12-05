<?php

namespace App\Shopsy\IdentityAccess\Main\Application\Command;

use App\Common\Application\Command\Command;

class DestroyUserCommand implements Command
{
    /**
     * @var int|string
     */
    private $id;

    /**
     * DestroyUserCommand constructor.
     *
     * @param $id
     */
    public function __construct($id)
    {
        $this->id = $id;
    }

    /**
     * Get the value of id
     *
     * @return  int|string
     */
    public function getId()
    {
        return $this->id;
    }
}
