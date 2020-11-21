<?php


namespace App\Shopsy\IdentityAccess\Domain\Exception;


use App\Common\Domain\DomainException;

class UserEmailNotUniqueException extends DomainException
{
    public $message = 'User with that email already exists.';
}