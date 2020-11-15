<?php

namespace App\Shopsy\Users\Domain\Model;

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
    public function __construct($fullName)
    {
        $this->assertNotEmpty($fullName);
        $this->assertNotTooShort($fullName);
        $this->assertNotTooLong($fullName);

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
     * Assert not empty
     *
     * @param string fullName
     *
     * @return void
     */
    private function assertNotEmpty($fullName)
    {
        if (empty($fullName)) {
            throw new \InvalidArgumentException('Empty Full name');
        }
    }

    /**
     * Assert not too short
     *
     * @param string fullName
     *
     * @return void
     */
    private function assertNotTooShort($fullName)
    {
        if (strlen($fullName) < self::MIN_LENGTH) {
            throw new \InvalidArgumentException(sprintf(
                'Full name must be %d characters or more',
                self::MIN_LENGTH
            ));
        }
    }

    /**
     * Assert not too long
     *
     * @param string fullName
     *
     * @return void
     */
    private function assertNotTooLong($fullName)
    {
        if (strlen($fullName) > self::MAX_LENGTH) {
            throw new \InvalidArgumentException(sprintf(
                'Full name must be %d characters or less',
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
        return $this->getFullName();
    }
}
