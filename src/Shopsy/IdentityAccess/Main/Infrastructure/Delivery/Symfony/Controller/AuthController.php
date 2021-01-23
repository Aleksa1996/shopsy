<?php

namespace App\Shopsy\IdentityAccess\Main\Infrastructure\Delivery\Symfony\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use App\Common\Application\Bus\Query\QueryBus;
use Symfony\Component\Routing\Annotation\Route;
use App\Common\Application\Bus\Command\CommandBus;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Shopsy\IdentityAccess\Main\Application\Query\UserQuery;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use App\Shopsy\IdentityAccess\Main\Application\Command\AuthUserCommand;
use App\Common\Infrastructure\Delivery\Symfony\Controller\BaseController;
use App\Common\Infrastructure\Delivery\Symfony\Decorator\QueryBusExceptionDecorator;
use App\Common\Infrastructure\Delivery\Symfony\Decorator\CommandBusExceptionDecorator;
use App\Shopsy\IdentityAccess\Main\Infrastructure\Delivery\Symfony\RequestDto\AuthUserDto;
use App\Shopsy\IdentityAccess\Main\Infrastructure\Delivery\Symfony\Exception\IdentityAccessQueryExceptionHandler;
use App\Shopsy\IdentityAccess\Main\Infrastructure\Delivery\Symfony\Exception\IdentityAccessCommandExceptionHandler;

class AuthController extends BaseController
{
    /**
     * @var QueryBus
     */
    private $queryBus;

    /**
     * @var CommandBus
     */
    private $commandBus;

    /**
     * @var Security
     */
    private $security;

    /**
     * AuthController Constructor
     *
     * @param CommandBus $serverConfiguration
     * @param Security $security
     */
    public function __construct(QueryBus $queryBus, CommandBus $commandBus, Security $security)
    {
        $this->queryBus = new QueryBusExceptionDecorator($queryBus, new IdentityAccessQueryExceptionHandler());
        $this->commandBus = new CommandBusExceptionDecorator($commandBus, new IdentityAccessCommandExceptionHandler());
        $this->security = $security;
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

    /**
     * @Route("/oauth2/me", name="oauth2_me", methods={"GET"})
     *
     * @return JsonResponse
     */
    public function me(Request $request)
    {
        $query = new UserQuery(['username' => empty($this->security->getUser()) ? '' : $this->security->getUser()->getUsername()]);
        $response = $this->queryBus->handle($query);

        return $this->json($response, JsonResponse::HTTP_OK, [], [
            'jsonApi' => true,
            'request' => $request
        ]);
    }
}
