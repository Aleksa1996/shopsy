<?php


namespace App\Shopsy\IdentityAccess\Main\Domain\Exception;


use App\Common\Domain\DomainException;

class UserAlreadyExistsException extends DomainException
{
    public $message = 'User already exists.';
}