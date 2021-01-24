<?php

namespace App\Shopsy\IdentityAccess\Main\Domain;


interface RoleQueryFactory
{
    /**
     * Create id query
     *
     * @param int $id
     *
     * @return mixed
     */
    public function byId($id);

    /**
     * Create filter query
     *
     * @param array $filter
     * @param Sort $sort
     *
     * @return mixed
     */
    public function filter($filter, $sort = null);

    /**
     * Create filter collection query
     *
     * @param array $filter
     * @param Pagination $pagination
     * @param Sort $sort
     *
     * @return mixed
     */
    public function filterCollection($filter, $pagination = null, $sort = null);
}
