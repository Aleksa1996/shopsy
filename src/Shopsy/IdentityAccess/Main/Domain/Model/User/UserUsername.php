<?php


namespace App\Shopsy\IdentityAccess\Main\Domain\Model\User;


use App\Common\Domain\Assert\Assert;

class UserUsername
{

    /**
     * Firstname
     *
     * @var string
     */
    private $username;

    const MIN_LENGTH = 2;
    const MAX_LENGTH = 200;

    /**
     * Constructor
     *
     * @param string $username
     */
    public function __construct(string $username)
    {
        Assert::that($username)
            ->notEmpty('User username is empty.')
            ->minLength(self::MIN_LENGTH, sprintf('User username must be at least %s characters long.', self::MIN_LENGTH))
            ->maxLength(self::MAX_LENGTH, sprintf('User username must be lower than %s characters.', self::MAX_LENGTH));

        $this->username = $username;
    }

    /**
     * Get first name
     *
     * @return  string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * To string
     *
     * @return string
     */
    public function __toString()
    {
        return $this->getUsername();
    }
}