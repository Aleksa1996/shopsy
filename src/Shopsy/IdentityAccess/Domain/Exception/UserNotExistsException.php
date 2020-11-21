<?php


namespace App\Shopsy\IdentityAccess\Domain\Exception;


use App\Common\Domain\DomainException;

class UserNotExistsException extends DomainException
{
    public $message = 'User does not exists.';
}