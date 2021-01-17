<?php

namespace App\Shopsy\IdentityAccess\Main\Infrastructure\Delivery\Symfony\Controller;

use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Routing\Annotation\Route;
use App\Common\Infrastructure\Delivery\Symfony\Controller\BaseController;

class ActionsController extends BaseController
{
    /**
     * @var RouterInterface
     */
    private $router;

    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    /**
     * @Route("/identity-access/actions", name="identity_access_actions_index", methods={"GET"})
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function index()
    {
        $routes = $this->router->getRouteCollection()->all();
        return $this->json($routes);
    }
}
