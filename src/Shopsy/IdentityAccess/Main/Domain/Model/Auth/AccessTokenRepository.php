<?php

namespace App\Shopsy\IdentityAccess\Main\Domain\Model\Auth;

use App\Common\Domain\Id;

interface AccessTokenRepository
{
    /**
     * @param Id $id
     *
     * @return AccessToken
     */
    public function findById(Id $id);

    /**
     * @param string $id
     *
     * @return AccessToken
     */
    public function findByIdentifier(string $id);

    /**
     * @param AccessToken $accessToken
     */
    public function add(AccessToken $accessToken);

    /**
     * @param AccessToken $accessToken
     */
    public function remove(AccessToken $accessToken);

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
