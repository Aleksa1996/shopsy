<?php

namespace App\Shopsy\IdentityAccess\Main\Infrastructure\Delivery\Symfony\Controller;

use Nyholm\Psr7\Response as Psr7Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use App\Common\Infrastructure\Delivery\Symfony\Controller\BaseController;
use App\Shopsy\IdentityAccess\Main\Domain\Service\Authentication;
use App\Shopsy\IdentityAccess\Main\Infrastructure\Delivery\Symfony\RequestDto\LoginUserDto;

class AuthController extends BaseController
{
    /**
     * @var Authentication
     */
    private $authentication;

    /**
     * AuthController Constructor
     *
     * @param Authentication $serverConfiguration
     */
    public function __construct(Authentication $authentication)
    {
        $this->authentication = $authentication;
    }

    /**
     * @Route("/oauth2/access_token", name="oauth2_access_token", methods={"POST"})
     * @ParamConverter("userDto", class="App\Shopsy\IdentityAccess\Main\Infrastructure\Delivery\Symfony\RequestDto\LoginUserDto")
     *
     * @param LoginUserDto $userDto
     * @param Request $request
     *
     * @return void
     */
    public function accessToken(LoginUserDto $userDto, Request $request)
    {
        $response = new Psr7Response();
        // TODO: inject service that handles authentication
        // try {
            $this->authentication->authenticate($userDto->username, $userDto->password);
        // } catch (OAuthServerException $e) {
        //     $response = $e->generateHttpResponse(new Psr7Response());
        // }
    }
}
