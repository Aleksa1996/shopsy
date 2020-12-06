<?php

namespace App\Shopsy\IdentityAccess\Main\Infrastructure\Delivery\Symfony\Controller;

use App\Common\Application\Bus\QueryBus;
use App\Common\Application\Bus\CommandBus;
use App\Common\Infrastructure\Delivery\Symfony\Controller\BaseController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Shopsy\IdentityAccess\Main\Application\Query\UserQuery;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use App\Shopsy\IdentityAccess\Main\Application\Command\CreateUserCommand;
use App\Shopsy\IdentityAccess\Main\Application\Command\UpdateUserCommand;
use App\Shopsy\IdentityAccess\Main\Application\Query\UserCollectionQuery;
use App\Shopsy\IdentityAccess\Main\Application\Command\DestroyUserCommand;
use App\Shopsy\IdentityAccess\Main\Infrastructure\Delivery\Symfony\Dto\CreateUserDto;
use App\Shopsy\IdentityAccess\Main\Infrastructure\Delivery\Symfony\Dto\UpdateUserDto;
use Symfony\Component\Serializer\SerializerInterface;

class UsersController extends BaseController
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
     * UsersController Constructor
     *
     * @param QueryBus $queryBus
     * @param CommandBus $commandBus
     */
    public function __construct(QueryBus $queryBus, CommandBus $commandBus, SerializerInterface $serializer)
    {
        $this->queryBus = $queryBus;
        $this->commandBus = $commandBus;
        $this->serializer = $serializer;
    }

    /**
     * @Route("/users", name="users_index", methods={"GET"})
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        $queryParams = $this->getQueryParams($request, [
            'page' => ['number' => 1, 'size' => 10],
            'filter' => [],
            'sort' => []
        ]);

        $query = new UserCollectionQuery(
            empty($queryParams['page']['number']) ? 1 : (int)$queryParams['page']['number'],
            empty($queryParams['page']['size']) ? 10 : (int)$queryParams['page']['size'],
            $queryParams['filter'],
            $queryParams['sort']
        );
        $response = $this->queryBus->handle($query);

        return $this->json($response, JsonResponse::HTTP_OK, [], [
            'jsonApi' => true,
            'request' => $request
        ]);
    }

    /**
     * @Route("/users/{id}", name="users_show", methods={"GET"})
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function show($id, Request $request)
    {
        $query = new UserQuery(['id' => $id]);
        $response = $this->queryBus->handle($query);

        return $this->json($response, JsonResponse::HTTP_OK, [], [
            'jsonApi' => true,
            'request' => $request
        ]);
    }

    /**
     * @Route("/users", name="users_create", methods={"POST"})
     * @ParamConverter("userDto", class="App\Shopsy\IdentityAccess\Main\Infrastructure\Delivery\Symfony\Dto\CreateUserDto")
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function create(Request $request, CreateUserDto $userDto)
    {
        $command = new CreateUserCommand(
            $userDto->fullName,
            $userDto->username,
            $userDto->email,
            $userDto->password
        );
        $this->commandBus->handle($command);

        $query = new UserQuery([
            'username' => $userDto->username,
            'email' => $userDto->email
        ]);
        $response = $this->queryBus->handle($query);

        return $this->json($response, JsonResponse::HTTP_CREATED, [], [
            'jsonApi' => true,
            'request' => $request
        ]);
    }

    /**
     * @Route("/users/{id}", name="users_update", methods={"PUT","PATCH"})
     * @ParamConverter("userDto", class="App\Shopsy\IdentityAccess\Main\Infrastructure\Delivery\Symfony\Dto\UpdateUserDto")
     *
     * @return JsonResponse
     */
    public function update($id, UpdateUserDto $userDto, Request $request)
    {
        $command = new UpdateUserCommand(
            $id,
            $userDto->fullName,
            $userDto->username,
            $userDto->email,
            $userDto->password
        );
        $this->commandBus->handle($command);

        $query = new UserQuery(['id' => $id]);
        $response = $this->queryBus->handle($query);

        return $this->json($response, JsonResponse::HTTP_OK, [], [
            'jsonApi' => true,
            'request' => $request
        ]);
    }

    /**
     * @Route("/users/{id}", name="users_destroy", methods={"DELETE"})
     *
     * @return JsonResponse
     */
    public function destroy($id, Request $request)
    {
        $query = new UserQuery(['id' => $id]);
        $response = $this->queryBus->handle($query);

        $command = new DestroyUserCommand($id);
        $this->commandBus->handle($command);

        return $this->json($response, JsonResponse::HTTP_OK, [], [
            'jsonApi' => true,
            'request' => $request
        ]);
    }
}
