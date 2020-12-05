<?php

namespace App\Shopsy\IdentityAccess\Main\Infrastructure\Persistence\Doctrine\Query;

use Doctrine\Common\Collections\Criteria;
use Doctrine\Common\Collections\Expr\Comparison;

class DoctrineUserUsernameQuery extends DoctrineUserQuery
{
    /**
     * @var string
     */
    private $username;

    /**
     * DoctrineUserUsernameQuery Constructor
     *
     * @param string $username
     */
    public function __construct($username)
    {
        $this->username = $username;
    }

    /**
     * @return mixed
     */
    public function criteria()
    {
        return Criteria::create()
            ->where(new Comparison('username', Comparison::EQ, $this->username));
    }
}
