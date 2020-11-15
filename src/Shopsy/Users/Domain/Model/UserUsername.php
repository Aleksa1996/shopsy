<?php


namespace App\Shopsy\Users\Domain\Model;


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
    public function __construct($username)
    {
        $this->assertNotEmpty($username);
        $this->assertNotTooShort($username);
        $this->assertNotTooLong($username);

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
     * Assert not empty
     *
     * @param string username
     *
     * @return void
     */
    private function assertNotEmpty($username)
    {
        if (empty($username)) {
            throw new \InvalidArgumentException('Empty Username');
        }
    }

    /**
     * Assert not too short
     *
     * @param string username
     *
     * @return void
     */
    private function assertNotTooShort($username)
    {
        if (strlen($username) < self::MIN_LENGTH) {
            throw new \InvalidArgumentException(sprintf(
                'Username must be %d characters or more',
                self::MIN_LENGTH
            ));
        }
    }

    /**
     * Assert not too long
     *
     * @param string username
     *
     * @return void
     */
    private function assertNotTooLong($username)
    {
        if (strlen($username) > self::MAX_LENGTH) {
            throw new \InvalidArgumentException(sprintf(
                'Username must be %d characters or less',
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
        return $this->getUsername();
    }
}