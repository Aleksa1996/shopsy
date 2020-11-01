<?php


namespace App\Shopsy\Users\Application\Service;


use App\Shared\Application\Service\ApplicationRequest;
use App\Shared\Application\Service\ApplicationService;
use App\Shopsy\Users\Application\DataTransformer\ArrayUserDataTransformer;
use App\Shopsy\Users\Application\DataTransformer\UserDataTransformer;
use App\Shopsy\Users\Domain\Model\PasswordHasher;
use App\Shopsy\Users\Domain\Model\User;
use App\Shopsy\Users\Domain\Model\UserAlreadyExistsException;
use App\Shopsy\Users\Domain\Model\UserEmail;
use App\Shopsy\Users\Domain\Model\UserFirstName;
use App\Shopsy\Users\Domain\Model\UserLastName;
use App\Shopsy\Users\Domain\Model\UserPassword;
use App\Shopsy\Users\Domain\Model\UserRepository;

class SignUpUserService implements ApplicationService
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @var ArrayUserDataTransformer
     */
    private $userDataTransformer;

    /**
     * @var PasswordHasher
     */
    private $passwordHasher;

    /**
     * SignUpUserService constructor.
     *
     * @param UserRepository $userRepository
     * @param UserDataTransformer $userDataTransformer
     * @param PasswordHasher $passwordHasher
     */
    public function __construct(UserRepository $userRepository, UserDataTransformer $userDataTransformer, PasswordHasher $passwordHasher)
    {
        $this->userRepository = $userRepository;
        $this->userDataTransformer = $userDataTransformer;
        $this->passwordHasher = $passwordHasher;
    }

    /**
     * @inheritDoc
     *
     * @throws UserAlreadyExistsException
     */
    public function execute(ApplicationRequest $request = null)
    {
        $user = $this->userRepository->findByEmail(
            new UserEmail($request->email)
        );

        if ($user !== null) {
            throw new UserAlreadyExistsException();
        }

        $user = new User(
            $this->userRepository->nextIdentity(),
            new UserFirstName($request->firstName),
            new UserLastName($request->lastName),
            new UserEmail($request->email),
            new UserPassword($this->passwordHasher->hash($request->password))
        );

        $this->userRepository->add($user);
        $this->userDataTransformer->write($user);

        return $this->userDataTransformer->read();
    }
}