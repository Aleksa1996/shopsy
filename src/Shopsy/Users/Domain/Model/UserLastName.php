<?php

namespace App\Shopsy\Users\Domain\Model;

class UserLastName
{
    /**
     * LastName
     *
     * @var string
     */
    private $lastName;

    const MIN_LENGTH = 2;
    const MAX_LENGTH = 200;

    /**
     * Constructor
     *
     * @param string $lastName
     */
    public function __construct($lastName)
    {
        $this->assertNotEmpty($lastName);
        $this->assertNotTooShort($lastName);
        $this->assertNotTooLong($lastName);

        $this->lastName = $lastName;
    }

    /**
     * Get firstname
     *
     * @return  string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Assert not empty
     *
     * @param string lastName
     *
     * @return void
     */
    private function assertNotEmpty($lastName)
    {
        if (empty($lastName)) {
            throw new \InvalidArgumentException('Empty Last name');
        }
    }

    /**
     * Assert not too short
     *
     * @param string lastName
     *
     * @return void
     */
    private function assertNotTooShort($lastName)
    {
        if (strlen($lastName) < self::MIN_LENGTH) {
            throw new \InvalidArgumentException(sprintf(
                'Last name must be %d characters or more',
                self::MIN_LENGTH
            ));
        }
    }

    /**
     * Assert not too long
     *
     * @param string lastName
     *
     * @return void
     */
    private function assertNotTooLong($lastName)
    {
        if (strlen($lastName) > self::MAX_LENGTH) {
            throw new \InvalidArgumentException(sprintf(
                'Last name must be %d characters or less',
                self::MAX_LENGTH
            ));
        }
    }

    /**
     * To string
     *
     * @return string
     */
    public function __toString()
    {
        return $this->getLastName();
    }
}
