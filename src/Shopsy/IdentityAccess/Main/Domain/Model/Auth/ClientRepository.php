<?php

namespace App\Shopsy\IdentityAccess\Main\Domain\Model\Auth;

use App\Common\Domain\Id;

interface ClientRepository
{
    /**
     * @param Id $id
     *
     * @return Client
     */
    public function findById(Id $id);

    /**
     * @return Client
     */
    public function findByGeneralPurposeAuthentication();

    /**
     * @param Client $client
     */
    public function add(Client $client);

    /**
     * @param Client $client
     */
    public function remove(Client $client);

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
