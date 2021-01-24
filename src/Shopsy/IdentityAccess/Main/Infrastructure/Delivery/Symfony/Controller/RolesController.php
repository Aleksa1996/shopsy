<?php

namespace App\Shopsy\IdentityAccess\Main\Infrastructure\Delivery\Symfony\Controller;

use Symfony\Component\HttpFoundation\Request;
use App\Common\Application\Bus\Query\QueryBus;
use Symfony\Component\Routing\Annotation\Route;
use App\Common\Application\Bus\Command\CommandBus;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Shopsy\IdentityAccess\Main\Application\Query\RoleQuery;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use App\Common\Infrastructure\Delivery\Symfony\Controller\BaseController;
use App\Shopsy\IdentityAccess\Main\Application\Command\CreateRoleCommand;
use App\Shopsy\IdentityAccess\Main\Application\Command\UpdateRoleCommand;
use App\Shopsy\IdentityAccess\Main\Application\Query\RoleCollectionQuery;
use App\Common\Infrastructure\Delivery\Symfony\Decorator\QueryBusExceptionDecorator;
use App\Common\Infrastructure\Delivery\Symfony\Decorator\CommandBusExceptionDecorator;
use App\Shopsy\IdentityAccess\Main\Infrastructure\Delivery\Symfony\RequestDto\CreateRoleDto;
use App\Shopsy\IdentityAccess\Main\Infrastructure\Delivery\Symfony\RequestDto\UpdateRoleDto;
use App\Shopsy\IdentityAccess\Main\Infrastructure\Delivery\Symfony\Exception\IdentityAccessQueryExceptionHandler;
use App\Shopsy\IdentityAccess\Main\Infrastructure\Delivery\Symfony\Exception\IdentityAccessCommandExceptionHandler;

class RolesController extends BaseController
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
     * RolesController Constructor
     *
     * @param QueryBus $queryBus
     * @param CommandBus $commandBus
     */
    public function __construct(QueryBus $queryBus, CommandBus $commandBus)
    {
        $this->queryBus = new QueryBusExceptionDecorator($queryBus, new IdentityAccessQueryExceptionHandler());
        $this->commandBus = new CommandBusExceptionDecorator($commandBus, new IdentityAccessCommandExceptionHandler());
    }

    /**
     * @Route("/identity-access/roles", name="identity_access_roles_index", methods={"GET"})
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

        $query = new RoleCollectionQuery(
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
     * @Route("/identity-access/roles/{id}", name="identity_access_roles_show", methods={"GET"})
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function show($id, Request $request)
    {
        $query = new RoleQuery(['id' => $id]);
        $response = $this->queryBus->handle($query);

        return $this->json($response, JsonResponse::HTTP_OK, [], [
            'jsonApi' => true,
            'request' => $request
        ]);
    }

    /**
     * @Route("/identity-access/roles", name="identity_access_roles_create", methods={"POST"})
     * @ParamConverter("roleDto", class="App\Shopsy\IdentityAccess\Main\Infrastructure\Delivery\Symfony\RequestDto\CreateRoleDto")
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function create(Request $request, CreateRoleDto $roleDto)
    {
        $command = new CreateRoleCommand(
            $roleDto->name,
            $roleDto->identifier,
            $roleDto->active,
            []
        );
        $this->commandBus->handle($command);

        $query = new RoleQuery([
            'name' => $roleDto->name,
            'identifier' => $roleDto->identifier
        ]);
        $response = $this->queryBus->handle($query);

        return $this->json($response, JsonResponse::HTTP_CREATED, [], [
            'jsonApi' => true,
            'request' => $request
        ]);
    }

    /**
     * @Route("/identity-access/roles/{id}", name="identity_access_roles_update", methods={"PUT","PATCH"})
     * @ParamConverter("roleDto", class="App\Shopsy\IdentityAccess\Main\Infrastructure\Delivery\Symfony\RequestDto\UpdateRoleDto")
     *
     * @return JsonResponse
     */
    public function update($id, UpdateRoleDto $roleDto, Request $request)
    {
        $command = new UpdateRoleCommand(
            $id,
            $roleDto->name,
            $roleDto->identifier,
            $roleDto->active,
            []
        );
        $this->commandBus->handle($command);

        $query = new RoleQuery(['id' => $id]);
        $response = $this->queryBus->handle($query);

        return $this->json($response, JsonResponse::HTTP_OK, [], [
            'jsonApi' => true,
            'request' => $request
        ]);
    }
}
