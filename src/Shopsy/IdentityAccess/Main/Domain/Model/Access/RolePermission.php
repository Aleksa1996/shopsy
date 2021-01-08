<?php

namespace App\Shopsy\IdentityAccess\Main\Domain\Model\Access;

use JsonSerializable;
use App\Common\Domain\Id;
use App\Common\Domain\ValueObject;
use App\Common\Domain\Assert\Assert;

class RolePermission extends ValueObject implements JsonSerializable
{
    /**
     * @var Id
     */
    protected $id;

    /**
     * @var string
     */
    protected $action;

    public const LIST_ACTION = 'LIST_ACTION';
    public const VIEW_ACTION = 'VIEW_ACTION';
    public const CREATE_ACTION = 'CREATE_ACTION';
    public const UPDATE_ACTION = 'UPDATE_ACTION';
    public const DELETE_ACTION = 'DELETE_ACTION';

    /**
     * @var string
     */
    protected $resource;

    /**
     * RolePermission Constructor
     *
     * @param Id $id
     * @param string $action
     * @param string $resource
     */
    public function __construct(Id $id, string $action, string $resource)
    {
        $this->id = $id;

        Assert::that($action)
            ->notEmpty('Permission action field is empty.')
            ->string('Permission action field must be string.')
            ->inArray(
                $this->getAvailableActions(),
                sprintf('Permission action field must be one of the following: %s', implode(', ', $this->getAvailableActions()))
            );

        $this->action = $action;

        Assert::that($resource)
            ->notEmpty('Permission resource field is empty.')
            ->string('Permission resource field must be string.');

        $this->resource = $resource;
    }

    /**
     * @return  Id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return  string
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * @return  string
     */
    public function getResource()
    {
        return $this->resource;
    }

    /**
     * @return array
     */
    public function getAvailableActions()
    {
        return [
            static::LIST_ACTION,
            static::VIEW_ACTION,
            static::CREATE_ACTION,
            static::UPDATE_ACTION,
            static::DELETE_ACTION
        ];
    }

    /**
     * @param string $action
     *
     * @return bool
     */
    public function equals(RolePermission $permission)
    {
        return $this->getAction() === $permission->getAction() && $this->getResource() === $permission->getResource();
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf('%s/%s', $this->getAction(), $this->getResource());
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'id' => $this->getId()->getId(),
            'action' => $this->getAction(),
            'resource' => $this->getResource()
        ];
    }
}
