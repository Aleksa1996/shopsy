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
            'fullName' => $user->getFullName()->getFullName(),
            'username' => $user->getUsername()->getUsername(),
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