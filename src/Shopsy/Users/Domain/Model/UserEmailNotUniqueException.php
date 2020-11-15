<?php


namespace App\Shopsy\Users\Domain\Model;


use App\Shared\Domain\DomainException;

class UserEmailNotUniqueException extends DomainException
{
    public $message = 'User with that email already exists.';
}