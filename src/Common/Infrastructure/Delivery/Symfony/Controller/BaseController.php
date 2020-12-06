<?php


namespace App\Common\Infrastructure\Delivery\Symfony\Controller;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BaseController extends AbstractController
{
    /**
     * @param Request $request
     * @param array $params
     *
     * @return void
     */
    protected function getQueryParams(Request $request, array $params)
    {
        $data = [];
        foreach ($params as $param => $default) {
            if (is_int($param)) {
                $data[$default] = $request->query->get($default);
            } else {
                $data[$param] = $request->query->get($param, $default);
            }
        }

        return $data;
    }
}
