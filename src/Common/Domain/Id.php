<?php

namespace App\Common\Domain;

use Ramsey\Uuid\Uuid;

class Id
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
     * @param null $id
     */
    public function __construct($id = null)
    {
        $this->id = $id ?? Uuid::uuid4()->toString();
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
     * Equals Id
     *
     * @return  string|int
     */
    public function equals(Id $id)
    {
        return $this->id === $id->getId();
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
