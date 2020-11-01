<?php


namespace App\Shopsy\Users\Infrastructure\Authentication\Oauth2\Entity;


use League\OAuth2\Server\Entities\ScopeEntityInterface;
use League\OAuth2\Server\Entities\Traits\EntityTrait;
use League\OAuth2\Server\Entities\Traits\ScopeTrait;

class Scope implements ScopeEntityInterface
{
    use EntityTrait, ScopeTrait;
}