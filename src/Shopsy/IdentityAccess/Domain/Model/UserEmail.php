<?php

namespace App\Shopsy\IdentityAccess\Domain\Model;

use App\Common\Assert\Assert;

class UserEmail
{
    /**
     * Email
     *
     * @var string
     */
    private $email;

    /**
     * Constructor
     *
     * @param string $email
     */
    public function __construct(string $email)
    {
        Assert::that($email)
            ->notEmpty('User email is empty.')
            ->email('User email is not in good format.');

        $this->email = $email;
    }

    /**
     * Get user email
     *
     * @return  string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * To string
     *
     * @return string
     */
    public function __toString()
    {
        return $this->getEmail();
    }
}
