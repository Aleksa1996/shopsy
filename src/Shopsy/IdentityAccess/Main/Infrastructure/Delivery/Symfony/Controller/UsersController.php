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
        $query = $this->getQueryParams($request, [
            'page' => ['number' => 1, 'size' => 10],
            'filter' => [],
            'sort' => []
        ]);

        $userQuery = new UserCollectionQuery(
            empty($query['page']['number']) ? 1 : (int)$query['page']['number'],
            empty($query['page']['size']) ? 10 : (int)$query['page']['size'],
            $query['filter'],
            $query['sort']
        );

        $userCollection = $this->queryBus->handle($userQuery);

        $users = $this->serializer->serialize($userCollection, 'json', [
            'jsonApi' => true,
            'routeName' => $request->get('_route')
        ]);

        return new JsonResponse($users, JsonResponse::HTTP_OK, [], true);
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

        // dd($user);

        $user = $this->serializer->serialize($user, 'json', [
            'jsonApi' => true,
            'routeName' => $request->get('_route')
        ]);

        return new JsonResponse($user, JsonResponse::HTTP_OK, [], true);

        // return new JsonResponse($user, JsonResponse::HTTP_OK);
    }

    /**
     * @Route("/users", name="users_create", methods={"POST"})
     * @ParamConverter("userDto", class="App\Shopsy\IdentityAccess\Main\Infrastructure\Delivery\Symfony\Dto\CreateUserDto")
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
     * @ParamConverter("userDto", class="App\Shopsy\IdentityAccess\Main\Infrastructure\Delivery\Symfony\Dto\UpdateUserDto")
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
