<?php


namespace App\Shopsy\IdentityAccess\Domain\Model;


interface UserRepository
{
    /**
     * @param UserId $userId
     *
     * @return User
     */
    public function findById(UserId $userId);

    /**
     * @param UserUsername $username
     *
     * @return User
     */
    public function findByUsername(UserUsername $username);

    /**
     * @param UserEmail $email
     *
     * @return User
     */
    public function findByEmail(UserEmail $email);

    /**
     * @param User $user
     */
    public function add(User $user);

    /**
     * @return UserId
     */
    public function nextIdentity();
}