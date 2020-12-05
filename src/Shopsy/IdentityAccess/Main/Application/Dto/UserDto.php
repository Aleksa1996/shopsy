<?php

namespace App\Shopsy\IdentityAccess\Main\Application\Dto;

use App\Common\Application\Dto\Dto;

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
     * Get the value of id
     *
     * @return  int|string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the value of fullName
     *
     * @return  string
     */
    public function getFullName()
    {
        return $this->fullName;
    }

    /**
     * Get the value of username
     *
     * @return  string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Get the value of email
     *
     * @return  string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Get the value of createdOn
     *
     * @return  string
     */
    public function getCreatedOn()
    {
        return $this->createdOn;
    }

    /**
     * Get the value of updatedOn
     *
     * @return  string
     */
    public function getUpdatedOn()
    {
        return $this->updatedOn;
    }
}
