<?php

namespace App\Shopsy\IdentityAccess\Domain\Model\User;

use App\Common\Domain\Assert\Assert;

class UserFullName
{

    /**
     * Firstname
     *
     * @var string
     */
    private $fullName;

    const MIN_LENGTH = 2;
    const MAX_LENGTH = 200;

    /**
     * Constructor
     *
     * @param string $fullName
     */
    public function __construct(string $fullName)
    {
        Assert::that($fullName)
            ->notEmpty('User Full name is empty.')
            ->minLength(self::MIN_LENGTH, sprintf('User Full name must be at least %s characters long.', self::MIN_LENGTH))
            ->maxLength(self::MAX_LENGTH, sprintf('User Full name must be lower than %s characters.', self::MAX_LENGTH));

        $this->fullName = $fullName;
    }

    /**
     * Get first name
     *
     * @return  string
     */
    public function getFullName()
    {
        return $this->fullName;
    }

    /**
     * To string
     *
     * @return string
     */
    public function __toString()
    {
        return $this->getFullName();
    }
}
