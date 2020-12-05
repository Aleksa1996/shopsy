<?php

namespace App\Shopsy\IdentityAccess\Main\Application\Dto;

use App\Common\Infrastructure\Application\Query\Dto\Dto;

class UserDto extends Dto
{
    /**
     * @var int|string
     */
    private $id;

    /**
     * @var string
     */
    private $fullName;

    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $createdOn;

    /**
     * @var string
     */
    private $updatedOn;

    /**
     * UserDto Constructor
     *
     * @param int|string $id
     * @param string $fullName
     * @param string $username
     * @param string $email
     * @param bool $active
     * @param string $avatar
     * @param string $signature
     * @param string $createdOn
     * @param string $updatedOn
     */
    public function __construct($id, $fullName, $username, $email, $createdOn, $updatedOn)
    {
        $this->id = $id;
        $this->fullName = $fullName;
        $this->username = $username;
        $this->email = $email;
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
    public function getFullName()
    {
        return $this->fullName;
    }

    /**
     * @return  string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @return  string
     */
    public function getEmail()
    {
        return $this->email;
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
