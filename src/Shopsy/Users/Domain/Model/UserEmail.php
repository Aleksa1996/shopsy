<?php

namespace App\Shopsy\Users\Domain\Model;

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
        $this->assertNotEmpty($email);
        $this->assertValidFormat($email);

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
     * Assert not empty
     *
     * @param string $email
     *
     * @return void
     */
    private function assertNotEmpty($email)
    {
        if (empty($email)) {
            throw new \InvalidArgumentException('Empty Email');
        }
    }

    /**
     * Assert format
     *
     * @param string $email
     *
     * @return void
     */
    private function assertValidFormat($email)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException('Invalid Email format');
        }
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
