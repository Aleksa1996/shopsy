<?php

namespace App\Shopsy\IdentityAccess\Main\Infrastructure\Delivery\Symfony\Controller;

use App\Common\Infrastructure\Delivery\Symfony\Controller\BaseController;
use Symfony\Component\Routing\Annotation\Route;

class RolesController extends BaseController
{
    /**
     * @Route("/identity-access/roles", name="identity_access_roles_index", methods={"GET"})
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function indexActions()
    {
    }
}