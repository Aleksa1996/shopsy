<?php

namespace App\Shopsy\IdentityAccess\Main\Domain;


interface UserQueryFactory
{
    /**
     * Create all query
     *
     * @param Pagination $pagination
     *
     * @return mixed
     */
    public function all($pagination = null);

    /**
     * Create id query
     *
     * @param int $id
     *
     * @return mixed
     */
    public function id($id);

    /**
     * Create username query
     *
     * @param string $username
     *
     * @return mixed
     */
    public function username($username);

    /**
     * Create filter query
     *
     * @param array $filter
     * @param Pagination $pagination
     * @param array $sort
     *
     * @return mixed
     */
    public function filter($filter, $pagination = null, $sort = []);
}
