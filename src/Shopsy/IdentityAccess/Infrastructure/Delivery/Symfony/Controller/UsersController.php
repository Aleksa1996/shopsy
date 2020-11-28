<?php

namespace App\Shopsy\IdentityAccess\Infrastructure\Delivery\Symfony\Controller;

use App\Common\Application\Bus\QueryBus;
use App\Common\Application\Bus\CommandBus;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Shopsy\IdentityAccess\Application\Query\UserQuery;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Shopsy\IdentityAccess\Application\Command\CreateUserCommand;
use App\Shopsy\IdentityAccess\Application\Command\DestroyUserCommand;
use App\Shopsy\IdentityAccess\Application\Command\UpdateUserCommand;
use App\Shopsy\IdentityAccess\Application\Query\UserCollectionQuery;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use App\Shopsy\IdentityAccess\Infrastructure\Delivery\Symfony\Dto\CreateUserDto;
use App\Shopsy\IdentityAccess\Infrastructure\Delivery\Symfony\Dto\UpdateUserDto;

class UsersController extends AbstractController
{
    /**
     * @var QueryBus
     */
    private $queryBus;

    /**
     * @var CommandBus
     */
    private $commandBus;


    public function __construct(QueryBus $queryBus, CommandBus $commandBus)
    {
        $this->queryBus = $queryBus;
        $this->commandBus = $commandBus;
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
        $userQuery = new UserCollectionQuery(
            $request->query->get('page') ? (int)$request->query->get('page') : 1,
            $request->query->get('limit') ? (int)$request->query->get('limit') : 10
        );

        $users = $this->queryBus->handle($userQuery);

        dd($users);

        $users = $this->serializer->serialize($users, 'json', [
            'jsonld' => true,
            'url' => '/users'
        ]);
        return new JsonResponse($users, JsonResponse::HTTP_OK, [], true);
        // return new JsonResponse($users, JsonResponse::HTTP_OK);
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
        $userQuery = new UserQuery($id);

        $user = $this->queryBus->handle($userQuery);

        dd($user);

        return new JsonResponse($user, JsonResponse::HTTP_OK);
    }

    /**
     * @Route("/users", name="users_create", methods={"POST"})
     * @ParamConverter("userDto", class="App\Shopsy\IdentityAccess\Infrastructure\Delivery\Symfony\Dto\CreateUserDto")
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function create(CreateUserDto $userDto)
    {
        $createUserCommand = new CreateUserCommand(
            $userDto->fullName,
            $userDto->username,
            $userDto->email,
            $userDto->password
        );

        $this->commandBus->handle($createUserCommand);

        $userQuery = new UserQuery(
            null,
            null,
            $userDto->username
        );

        $user = $this->queryBus->handle($userQuery);

        dd($user);

        return new JsonResponse($user, JsonResponse::HTTP_CREATED);
    }

    /**
     * @Route("/users/{id}", name="users_update", methods={"PUT","PATCH"})
     * @ParamConverter("userDto", class="App\Shopsy\IdentityAccess\Infrastructure\Delivery\Symfony\Dto\UpdateUserDto")
     *
     * @return JsonResponse
     */
    public function update($id, UpdateUserDto $userDto)
    {
        $updateUserCommand = new UpdateUserCommand(
            $id,
            $userDto->fullName,
            $userDto->username,
            $userDto->email,
            $userDto->password
        );

        $this->commandBus->handle($updateUserCommand);

        $userQuery = new UserQuery(
            $id
        );

        $user = $this->queryBus->handle($userQuery);

        dd($user);

        return new JsonResponse($user, JsonResponse::HTTP_OK);
    }

    /**
     * @Route("/users/{id}", name="users_destroy", methods={"DELETE"})
     *
     * @return JsonResponse
     */
    public function destroy($id)
    {
        $userQuery = new UserQuery(
            $id
        );

        $user = $this->queryBus->handle($userQuery);

        $destroyUserCommand = new DestroyUserCommand(
            $id
        );

        $this->commandBus->handle($destroyUserCommand);

        dd($user);

        return new JsonResponse($user, JsonResponse::HTTP_OK);
    }
}
