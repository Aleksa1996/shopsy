<?php

namespace App\Shopsy\IdentityAccess\Main\Infrastructure\Delivery\Symfony\Controller;

use App\Common\Application\Bus\Command\CommandBus;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use App\Common\Infrastructure\Delivery\Symfony\Controller\BaseController;
use App\Shopsy\IdentityAccess\Main\Application\Command\LoginUserCommand;
use App\Shopsy\IdentityAccess\Main\Infrastructure\Delivery\Symfony\RequestDto\LoginUserDto;

class AuthController extends BaseController
{
    /**
     * @var CommandBus
     */
    private $commandBus;

    /**
     * AuthController Constructor
     *
     * @param CommandBus $serverConfiguration
     */
    public function __construct(CommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    /**
     * @Route("/oauth2/access_token", name="oauth2_access_token", methods={"POST"})
     * @ParamConverter("userDto", class="App\Shopsy\IdentityAccess\Main\Infrastructure\Delivery\Symfony\RequestDto\LoginUserDto")
     *
     * @param LoginUserDto $userDto
     * @param Request $request
     *
     * @return void
     */
    public function accessToken(LoginUserDto $userDto, Request $request)
    {
        // TODO: inject service that handles authentication
        // try {
        $commandResult = $this->commandBus->handle(new LoginUserCommand($userDto->username, $userDto->password));

        dd($commandResult);
        // $this->authentication->authenticate($userDto->username, $userDto->password);
        // } catch (OAuthServerException $e) {
        //     $response = $e->generateHttpResponse(new Psr7Response());
        // }
    }
}
