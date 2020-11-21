<?php


namespace App\Shopsy\IdentityAccess\Domain\Exception;


use App\Common\Domain\DomainException;

class UserUsernameNotUniqueException extends DomainException
{
    public $message = 'User with that username already exists.';
}