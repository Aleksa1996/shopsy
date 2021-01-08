<?php

namespace App\Shopsy\IdentityAccess\Main\Domain\Model\Access;

use App\Common\Domain\Id;

interface RoleRepository
{
    /**
     * @param Id $id
     *
     * @return Role
     */
    public function findById(Id $id);

    /**
     * @param string $identifier
     *
     * @return Role
     */
    public function findByIdentifier(string $identifier);

    /**
     * @param Role $role
     */
    public function add(Role $role);

    /**
     * @param Role $role
     */
    public function remove(Role $role);

    /**
     * @return Id
     */
    public function nextIdentity();

    /**
     * @param mixed $query
     *
     * @return RepositoryQueryResult
     */
    public function query($query);
}
