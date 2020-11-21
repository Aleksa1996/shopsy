<?php


namespace App\Shopsy\IdentityAccess\Domain\Service;


use App\Shopsy\IdentityAccess\Domain\Exception\UserNotExistsException;
use App\Shopsy\IdentityAccess\Domain\Model\User;
use App\Shopsy\IdentityAccess\Domain\Model\UserPassword;
use App\Shopsy\IdentityAccess\Domain\Model\UserRepository;

abstract class Authentication
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * Authentication constructor.
     *
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     *
     * @param $usernameOrEmail
     * @param UserPassword $password
     *
     * @return bool
     *
     * @throws UserNotExistsException
     */
    public function authenticate($usernameOrEmail, UserPassword $password)
    {
//        DomainEventPublisher::instance()
//            ->publish(
//                new LogInAttempted($usernameOrEmail)
//            );

        if ($this->isAlreadyAuthenticated()) {
            return true;
        }

        $user = $this->userRepository->findByEmail($usernameOrEmail);
        if (!$user) {
            throw new UserNotExistsException();
        }

        if (!$this->auth($usernameOrEmail, $password, $user)) {
            return false;
        }

        $this->persistAuthentication($user);

        return true;
    }

    /**
     * @return mixed
     */
    abstract protected function isAlreadyAuthenticated();

    /**
     * @param $email
     * @param $password
     * @param $user
     *
     * @return bool
     */
    abstract protected function auth($email, $password, $user);

    /**
     * @return mixed
     */
    abstract public function logout();

    /**
     * @param User $user
     *
     * @return mixed
     */
    abstract protected function persistAuthentication(User $user);
}