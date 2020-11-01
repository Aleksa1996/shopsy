<?php

namespace App\Shopsy\Users\Domain\Model;

use Ramsey\Uuid\Uuid;

class UserId
{

    /**
     * Id
     *
     * @var string|int
     */
    private $id;

    /**
     * Constructor
     *
     * @param string|int $id
     */
    public function __construct($id = null)
    {
        $this->id = $id ?? Uuid::uuid4();
    }

    /**
     * Get Id
     *
     * @return  string|int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * To string
     *
     * @return string
     */
    public function __toString()
    {
        return (string)$this->id;
    }
}
