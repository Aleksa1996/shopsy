<?php

namespace App\Shopsy\Users\Domain\Model;

class UserFirstName
{

    /**
     * Firstname
     *
     * @var string
     */
    private $firstName;

    const MIN_LENGTH = 2;
    const MAX_LENGTH = 200;

    /**
     * Constructor
     *
     * @param string $firstName
     */
    public function __construct($firstName)
    {
        $this->assertNotEmpty($firstName);
        $this->assertNotTooShort($firstName);
        $this->assertNotTooLong($firstName);

        $this->firstName = $firstName;
    }

    /**
     * Get first name
     *
     * @return  string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Assert not empty
     *
     * @param string firstName
     *
     * @return void
     */
    private function assertNotEmpty($firstName)
    {
        if (empty($firstName)) {
            throw new \InvalidArgumentException('Empty First name');
        }
    }

    /**
     * Assert not too short
     *
     * @param string firstName
     *
     * @return void
     */
    private function assertNotTooShort($firstName)
    {
        if (strlen($firstName) < self::MIN_LENGTH) {
            throw new \InvalidArgumentException(sprintf(
                'First name must be %d characters or more',
                self::MIN_LENGTH
            ));
        }
    }

    /**
     * Assert not too long
     *
     * @param string firstName
     *
     * @return void
     */
    private function assertNotTooLong($firstName)
    {
        if (strlen($firstName) > self::MAX_LENGTH) {
            throw new \InvalidArgumentException(sprintf(
                'First name must be %d characters or less',
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
        return $this->getFirstName();
    }
}
