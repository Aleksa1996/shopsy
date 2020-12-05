<?php


namespace App\Shopsy\IdentityAccess\Main\Domain\Model\User;


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
     * @param User $user
     */
    public function remove(User $user);

    /**
     * @return UserId
     */
    public function nextIdentity();

    /**
     * @param mixed $query
     *
     * @return User[]|User|Paginator
     */
    public function query($query);
}