<?php

namespace App\Shopsy\IdentityAccess\Main\Infrastructure\Delivery\Symfony\Controller;

use Symfony\Component\HttpFoundation\Request;
use App\Common\Application\Bus\Query\QueryBus;
use Symfony\Component\Routing\Annotation\Route;
use App\Common\Application\Bus\Command\CommandBus;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Shopsy\IdentityAccess\Main\Application\Query\UserQuery;
use App\Common\Infrastructure\Service\FileUploader\FileUploader;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use App\Common\Infrastructure\Delivery\Symfony\Controller\BaseController;
use App\Shopsy\IdentityAccess\Main\Application\Command\CreateUserCommand;
use App\Shopsy\IdentityAccess\Main\Application\Command\UpdateUserCommand;
use App\Shopsy\IdentityAccess\Main\Application\Query\UserCollectionQuery;
use App\Shopsy\IdentityAccess\Main\Application\Command\DestroyUserCommand;
use App\Common\Infrastructure\Delivery\Symfony\Decorator\QueryBusExceptionDecorator;
use App\Common\Infrastructure\Delivery\Symfony\Decorator\CommandBusExceptionDecorator;
use App\Shopsy\IdentityAccess\Main\Infrastructure\Delivery\Symfony\RequestDto\CreateUserDto;
use App\Shopsy\IdentityAccess\Main\Infrastructure\Delivery\Symfony\RequestDto\UpdateUserDto;
use App\Shopsy\IdentityAccess\Main\Infrastructure\Delivery\Symfony\RequestDto\UploadUserAvatarDto;
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
     * @var FileUploader
     */
    private $fileUploader;

    /**
     * UsersController Constructor
     *
     * @param QueryBus $queryBus
     * @param CommandBus $commandBus
     */
    public function __construct(QueryBus $queryBus, CommandBus $commandBus, FileUploader $fileUploader)
    {
        $this->queryBus = new QueryBusExceptionDecorator($queryBus, new IdentityAccessQueryExceptionHandler());
        $this->commandBus = new CommandBusExceptionDecorator($commandBus, new IdentityAccessCommandExceptionHandler());
        $this->fileUploader = $fileUploader;
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
            null
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
            null
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
    public function destroy($id)
    {
        $command = new DestroyUserCommand($id);
        $this->commandBus->handle($command);

        return new JsonResponse(null, JsonResponse::HTTP_NO_CONTENT);
    }

    /**
     * @Route("/users/{id}/avatar", name="users_avatar", methods={"POST"})
     * @ParamConverter("uploadUserAvatarDto", class="App\Shopsy\IdentityAccess\Main\Infrastructure\Delivery\Symfony\RequestDto\UploadUserAvatarDto")
     *
     * @return JsonResponse
     */
    public function avatar($id, UploadUserAvatarDto $uploadUserAvatarDto, Request $request)
    {
        $path = sprintf('/identity_access/users/avatar/%s/avatar.%s', $id, $uploadUserAvatarDto->avatar->guessExtension());
        $this->fileUploader->upload(
            $path,
            fopen($uploadUserAvatarDto->avatar->getPathname(), 'r')
        );

        return new JsonResponse(['url' => sprintf('http://localstack.devshopsy.com%s', $path)], 201);
    }
}
