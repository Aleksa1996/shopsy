<?php

namespace App\Common\Infrastructure\Delivery\Symfony\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;


class IndexController extends BaseController
{
    /**
     * @Route("/", name="json_api_index", methods={"GET"})
     *
     * @return JsonResponse
     */
    public function jsonApi()
    {
        $response = [
            'jsonapi' => [
                'version' => '1.0'
            ]
        ];

        return new JsonResponse($response);
    }
}
