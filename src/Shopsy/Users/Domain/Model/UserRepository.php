<?php


namespace App\Shopsy\Users\Domain\Model;


interface UserRepository
{
    /**
     * @param UserId $userId
     *
     * @return User
     */
    public function findById(UserId $userId);

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