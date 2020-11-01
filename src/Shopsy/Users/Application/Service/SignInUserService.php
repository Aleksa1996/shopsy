<?php


namespace App\Shopsy\Users\Application\Service;


use App\Shared\Application\Service\ApplicationRequest;
use App\Shared\Application\Service\ApplicationService;
use App\Shopsy\Users\Application\DataTransformer\UserDataTransformer;
use App\Shopsy\Users\Domain\Model\Authentication;
use App\Shopsy\Users\Domain\Model\UserEmail;
use App\Shopsy\Users\Domain\Model\UserNotExistsException;
use App\Shopsy\Users\Domain\Model\UserPassword;

class SignInUserService implements ApplicationService
{

    /**
     * @var Authentication
     */
    private $authentication;

    /**
     * @var UserDataTransformer
     */
    private $userDataTransformer;

    public function __construct(Authentication $authentication, UserDataTransformer $userDataTransformer)
    {
        $this->authentication = $authentication;
        $this->userDataTransformer = $userDataTransformer;
    }

    /**
     * @inheritDoc
     *
     * @throws UserNotExistsException
     */
    public function execute(ApplicationRequest $request = null)
    {
        $data = $this->authentication->authenticate(
            new UserEmail($request->email),
            new UserPassword($request->password)
        );


    }
}