<?php


namespace App\Shopsy\Users\Application\DataTransformer;

use App\Shopsy\Users\Domain\Model\User;

class ArrayUserDataTransformer implements UserDataTransformer
{
    /**
     * @var mixed
     */
    private $data;

    /**
     * @inheritDoc
     */
    public function write(User $user)
    {
        $this->data = [
            'id' => $user->getId()->getId(),
            'firstName' => $user->getFirstName()->getFirstName(),
            'lastName' => $user->getLastName()->getLastName(),
            'email' => $user->getEmail()->getEmail()
        ];
    }

    /**
     * @inheritDoc
     */
    public function read()
    {
        return $this->data;
    }
}