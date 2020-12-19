<?php

namespace App\Shopsy\IdentityAccess\Main\Domain\Model\Auth;

use App\Common\Domain\Id;

interface RefreshTokenRepository
{
    /**
     * @param Id $id
     *
     * @return RefreshToken
     */
    public function findById(Id $id);

    /**
     * @param RefreshToken $refreshToken
     */
    public function add(RefreshToken $refreshToken);

    /**
     * @param RefreshToken $refreshToken
     */
    public function remove(RefreshToken $refreshToken);

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
