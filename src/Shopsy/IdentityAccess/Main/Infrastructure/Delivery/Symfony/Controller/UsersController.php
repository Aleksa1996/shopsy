<?php

namespace App\Shopsy\IdentityAccess\Main\Infrastructure\Delivery\Symfony\Controller;

use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\Request;
use App\Common\Application\Bus\Query\QueryBus;
use Symfony\Component\Routing\Annotation\Route;
use App\Common\Application\Bus\Command\CommandBus;
use App\Common\Infrastructure\ServerConfiguration;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Shopsy\IdentityAccess\Main\Application\Query\UserQuery;
use App\Common\Infrastructure\Service\FileUploader\FileUploader;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use App\Common\Infrastructure\Delivery\Symfony\Controller\BaseController;
use App\Shopsy\IdentityAccess\Main\Application\Command\CreateUserCommand;
use App\Shopsy\IdentityAccess\Main\Application\Command\UpdateUserCommand;
use App\Shopsy\IdentityAccess\Main\Application\Query\UserCollectionQuery;
use App\Shopsy\IdentityAccess\Main\Application\Command\DestroyUserCommand;
use App\Shopsy\IdentityAccess\Main\Application\Query\UserRolesCollectionQuery;
use App\Shopsy\IdentityAccess\Main\Application\Command\AttachRolesToUserCommand;
use App\Shopsy\IdentityAccess\Main\Application\Command\DetachRolesFromUserCommand;
use App\Common\Infrastructure\Delivery\Symfony\Decorator\QueryBusExceptionDecorator;
use App\Common\Infrastructure\Delivery\Symfony\Decorator\CommandBusExceptionDecorator;
use App\Shopsy\IdentityAccess\Main\Application\Command\ReplaceRolesOfUserCommand;
use App\Shopsy\IdentityAccess\Main\Infrastructure\Delivery\Symfony\RequestDto\CreateUserDto;
use App\Shopsy\IdentityAccess\Main\Infrastructure\Delivery\Symfony\RequestDto\UpdateUserDto;
use App\Shopsy\IdentityAccess\Main\Infrastructure\Delivery\Symfony\RequestDto\UploadUserAvatarDto;
use App\Shopsy\IdentityAccess\Main\Infrastructure\Delivery\Symfony\RequestDto\AttachRolesToUserDto;
use App\Shopsy\IdentityAccess\Main\Infrastructure\Delivery\Symfony\RequestDto\ReplaceRolesOfUserDto;
use App\Shopsy\IdentityAccess\Main\Infrastructure\Delivery\Symfony\RequestDto\DetachRolesFromUserDto;
use App\Shopsy\IdentityAccess\Main\Infrastructure\Delivery\Symfony\Exception\IdentityAccessQueryExceptionHandler;
use App\Shopsy\IdentityAccess\Main\Infrastructure\Delivery\Symfony\Exception\IdentityAccessCommandExceptionHandler;

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
     * @var ServerConfiguration
     */
    private $serverConfiguration;

    /**
     * @var FileUploader
     */
    private $fileUploader;

    /**
     * UsersController Constructor
     *
     * @param QueryBus $queryBus
     * @param CommandBus $commandBus
     */
    public function __construct(QueryBus $queryBus, CommandBus $commandBus, ServerConfiguration $serverConfiguration, FileUploader $fileUploader)
    {
        $this->queryBus = new QueryBusExceptionDecorator($queryBus, new IdentityAccessQueryExceptionHandler());
        $this->commandBus = new CommandBusExceptionDecorator($commandBus, new IdentityAccessCommandExceptionHandler());
        $this->serverConfiguration = $serverConfiguration;
        $this->fileUploader = $fileUploader;
    }

    /**
     * @Route("/identity-access/users", name="identity_access_users_index", methods={"GET"})
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        $queryParams = $this->getQueryParams($request, [
            'page',
            'filter',
            'sort'
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
     * @Route("/identity-access/users/{id}", name="identity_access_users_show", methods={"GET"})
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
     * @Route("/identity-access/users", name="identity_access_users_create", methods={"POST"})
     * @ParamConverter("userDto", class="App\Shopsy\IdentityAccess\Main\Infrastructure\Delivery\Symfony\RequestDto\CreateUserDto")
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
            $userDto->password,
            $userDto->active,
            $userDto->avatar
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
     * @Route("/identity-access/users/{id}", name="identity_access_users_update", methods={"PUT","PATCH"})
     * @ParamConverter("userDto", class="App\Shopsy\IdentityAccess\Main\Infrastructure\Delivery\Symfony\RequestDto\UpdateUserDto")
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
            $userDto->password,
            $userDto->active,
            $userDto->avatar
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
     * @Route("/identity-access/users/avatar", name="identity_access_users_avatar", methods={"POST"})
     * @ParamConverter("uploadUserAvatarDto", class="App\Shopsy\IdentityAccess\Main\Infrastructure\Delivery\Symfony\RequestDto\UploadUserAvatarDto")
     *
     * @return JsonResponse
     */
    public function avatar(UploadUserAvatarDto $uploadUserAvatarDto, Request $request)
    {
        $path = sprintf('/users/avatar/%s/avatar.%s',  Uuid::uuid6()->toString(), $uploadUserAvatarDto->avatar->guessExtension());

        $this->fileUploader->upload(
            $path,
            fopen($uploadUserAvatarDto->avatar->getPathname(), 'r')
        );

        $bucketUrl = $this->serverConfiguration->getEnv('APP_IDENTITY_ACCESS_AWS_BUCKET', 'http://localstack.devshopsy.com/identity-access');
        return new JsonResponse([
            'url' => $bucketUrl . $path
        ], 201);
    }


    /**
     * @Route("/identity-access/users/{id}/roles", name="identity_access_users_index_roles", methods={"GET"})
     *
     * @return JsonResponse
     */
    public function rolesIndex($id, Request $request)
    {
        $queryParams = $this->getQueryParams($request, [
            'page',
            'filter',
            'sort'
        ]);

        $query = new UserRolesCollectionQuery(
            $id,
            empty($queryParams['page']['number']) ? 1 : (int)$queryParams['page']['number'],
            empty($queryParams['page']['size']) ? 10 : (int)$queryParams['page']['size'],
            $queryParams['filter'] ?? [],
            $queryParams['sort'] ?? []
        );

        $response = $this->queryBus->handle($query);

        return $this->json($response, JsonResponse::HTTP_OK, [], [
            'jsonApi' => true,
            'request' => $request
        ]);
    }

    /**
     * @Route("/identity-access/users/{id}/roles", name="identity_access_users_create_roles", methods={"POST"})
     * @ParamConverter("userRolesDto", class="App\Shopsy\IdentityAccess\Main\Infrastructure\Delivery\Symfony\RequestDto\AttachRolesToUserDto")
     *
     * @return JsonResponse
     */
    public function rolesCreate($id, AttachRolesToUserDto $userRolesDto, Request $request)
    {
        $command = new AttachRolesToUserCommand(
            $id,
            $userRolesDto->id
        );

        $response = $this->commandBus->handle($command);

        return $this->json($response, JsonResponse::HTTP_NO_CONTENT, [], [
            'jsonApi' => true,
            'request' => $request
        ]);
    }

    /**
     * @Route("/identity-access/users/{id}/roles", name="identity_access_users_update_roles", methods={"PUT","PATCH"})
     * @ParamConverter("userRolesDto", class="App\Shopsy\IdentityAccess\Main\Infrastructure\Delivery\Symfony\RequestDto\ReplaceRolesOfUserDto")
     *
     * @return JsonResponse
     */
    public function rolesUpdate($id, ReplaceRolesOfUserDto $userRolesDto, Request $request)
    {
        $command = new ReplaceRolesOfUserCommand(
            $id,
            $userRolesDto->id
        );

        $response = $this->commandBus->handle($command);

        return $this->json($response, JsonResponse::HTTP_NO_CONTENT, [], [
            'jsonApi' => true,
            'request' => $request
        ]);
    }

    /**
     * @Route("/identity-access/users/{id}/roles", name="identity_access_users_destroy_roles", methods={"DELETE"})
     * @ParamConverter("userRolesDto", class="App\Shopsy\IdentityAccess\Main\Infrastructure\Delivery\Symfony\RequestDto\DetachRolesFromUserDto")
     *
     * @return JsonResponse
     */
    public function rolesDestroy($id, DetachRolesFromUserDto $userRolesDto, Request $request)
    {
        $command = new DetachRolesFromUserCommand(
            $id,
            $userRolesDto->id
        );

        $response = $this->commandBus->handle($command);

        return $this->json($response, JsonResponse::HTTP_NO_CONTENT, [], [
            'jsonApi' => true,
            'request' => $request
        ]);
    }
}
