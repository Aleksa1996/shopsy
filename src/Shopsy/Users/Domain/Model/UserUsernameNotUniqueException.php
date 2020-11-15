<?php


namespace App\Shopsy\Users\Domain\Model;


use App\Shared\Domain\DomainException;

class UserUsernameNotUniqueException extends DomainException
{
    public $message = 'User with that username already exists.';
}