<?php

namespace App\Shopsy\IdentityAccess\Main\Domain\Model\Access;

use DateTimeImmutable;
use App\Common\Domain\Id;

class Role
{
    /**
     * @var Id
     */
    protected $id;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $identifier;

    /**
     * @var RolePermission[]
     */
    protected $permissions = [];

    /**
     * @var DateTimeImmutable
     */
    protected $createdOn;

    /**
     * @var DateTimeImmutable
     */
    protected $updatedOn;

    /**
     * Role Constructor
     *
     * @param Id $id
     * @param string $name
     * @param string $identifier
     */
    public function __construct(Id $id, string $name, string $identifier, array $permissions = [])
    {
        $this->setId($id);
        $this->setName($name);
        $this->setIdentifier($identifier);
        $this->setPermissions($permissions);
        $this->setCreatedOn(new DateTimeImmutable());
        $this->setUpdatedOn(new DateTimeImmutable());
    }

    /**
     * Get the value of id
     *
     * @return  Id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param  Id  $id
     *
     * @return  self
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return  string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param  string  $name
     *
     * @return  self
     */
    public function setName(string $name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return  string
     */
    public function getIdentifier()
    {
        return $this->identifier;
    }

    /**
     * @param  string  $identifier
     *
     * @return  self
     */
    public function setIdentifier(string $identifier)
    {
        $this->identifier = $identifier;

        return $this;
    }

    /**
     * @return  RolePermission[]
     */
    public function getPermissions()
    {
        return $this->permissions;
    }

    /**
     * @param  RolePermission[]  $permissions
     *
     * @return  self
     */
    public function setPermissions(array $permissions)
    {
        $this->permissions = $permissions;

        return $this;
    }

    /**
     * @param string $action
     * @param string $resource
     *
     * @return self
     */
    public function addPermission(string $action, string $resource)
    {
        $addPermission = new RolePermission(new Id(), $action, $resource);

        foreach ($this->permissions as $key => $permission) {
            if ($permission->equals($addPermission)) {
                return $this;
            }
        }

        $this->permissions[] = $addPermission;

        return $this;
    }

    /**
     * @param string $action
     * @param string $resource
     *
     * @return self
     */
    public function removePermission(string $action, string $resource)
    {
        $removePermission = new RolePermission(new Id(), $action, $resource);

        foreach ($this->permissions as $key => $permission) {
            if ($permission->equals($removePermission)) {
                unset($this->permissions[$key]);
                break;
            }
        }

        return $this;
    }

    /**
     * @param string $action
     * @param string $resource
     *
     * @return bool
     */
    public function hasPermission(string $action, string $resource)
    {
        $hasPermission = new RolePermission(new Id(), $action, $resource);

        foreach ($this->permissions as $permission) {
            if ($permission->equals($hasPermission)) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param string $action
     * @param string $resource
     *
     * @return bool
     */
    public function doesNotHavePermission(string $action, string $resource)
    {
        !$this->hasPermission($action, $resource);
    }

    /**
     * @return  DateTimeImmutable
     */
    public function getCreatedOn()
    {
        return $this->createdOn;
    }

    /**
     * @param  DateTimeImmutable  $createdOn
     *
     * @return  self
     */
    public function setCreatedOn(DateTimeImmutable $createdOn)
    {
        $this->createdOn = $createdOn;

        return $this;
    }

    /**
     * @return  DateTimeImmutable
     */
    public function getUpdatedOn()
    {
        return $this->updatedOn;
    }

    /**
     * @param  DateTimeImmutable  $updatedOn
     *
     * @return  self
     */
    public function setUpdatedOn(DateTimeImmutable $updatedOn)
    {
        $this->updatedOn = $updatedOn;

        return $this;
    }
}
