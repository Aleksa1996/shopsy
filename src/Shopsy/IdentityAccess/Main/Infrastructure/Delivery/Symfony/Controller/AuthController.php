<?php

namespace App\Shopsy\IdentityAccess\Main\Infrastructure\Delivery\Symfony\Controller;

use Symfony\Component\Routing\Annotation\Route;
use App\Common\Application\Bus\Command\CommandBus;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use App\Shopsy\IdentityAccess\Main\Application\Command\AuthUserCommand;
use App\Common\Infrastructure\Delivery\Symfony\Controller\BaseController;
use App\Common\Infrastructure\Delivery\Symfony\Decorator\CommandBusExceptionDecorator;
use App\Shopsy\IdentityAccess\Main\Infrastructure\Delivery\Symfony\RequestDto\AuthUserDto;
use App\Shopsy\IdentityAccess\Main\Infrastructure\Delivery\Symfony\Exception\IdentityAccessCommandExceptionHandler;

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
        $this->commandBus = new CommandBusExceptionDecorator($commandBus, new IdentityAccessCommandExceptionHandler());
    }

    /**
     * @Route("/oauth2/access_token", name="oauth2_access_token", methods={"POST"})
     * @ParamConverter("userDto", class="App\Shopsy\IdentityAccess\Main\Infrastructure\Delivery\Symfony\RequestDto\AuthUserDto")
     *
     * @param AuthUserDto $userDto
     *
     * @return JsonResponse
     */
    public function accessToken(AuthUserDto $userDto)
    {
        $commandResult = $this->commandBus->handle(
            new AuthUserCommand($userDto->username, $userDto->password)
        );

        return $this->json($commandResult, JsonResponse::HTTP_OK);
    }
}
