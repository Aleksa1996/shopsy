<?php

namespace App\Shopsy\IdentityAccess\Main\Infrastructure\Delivery\Symfony\Controller;

use Nyholm\Psr7\Factory\Psr17Factory;
use Psr\Http\Message\ResponseInterface;
use Nyholm\Psr7\Response as Psr7Response;
use Psr\Http\Message\ServerRequestInterface;
use League\OAuth2\Server\AuthorizationServer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Common\Infrastructure\ServerConfiguration;
use League\OAuth2\Server\Exception\OAuthServerException;
use Symfony\Bridge\PsrHttpMessage\Factory\PsrHttpFactory;
use Symfony\Bridge\PsrHttpMessage\Factory\HttpFoundationFactory;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use App\Common\Infrastructure\Delivery\Symfony\Controller\BaseController;
use App\Shopsy\IdentityAccess\Main\Infrastructure\Delivery\Symfony\RequestDto\LoginUserDto;

class AuthController extends BaseController
{
    /**
     * @var AuthorizationServer
     */
    private $authorizationServer;

    /**
     * @var ServerConfiguration
     */
    private $serverConfiguration;

    /**
     * AuthController Constructor
     *
     * @param AuthorizationServer $authorizationServer
     * @param ServerConfiguration $serverConfiguration
     */
    // public function __construct(AuthorizationServer $authorizationServer, ServerConfiguration $serverConfiguration)
    // {
    //     $this->authorizationServer = $authorizationServer;
    //     $this->serverConfiguration = $serverConfiguration;
    // }

    /**
     * @Route("/oauth2/access_token", name="oauth2_access_token", methods={"POST"})
     * @ParamConverter("userDto", class="App\DBP\IdentityAccess\Main\Infrastructure\Delivery\Symfony\RequestDto\LoginUserDto")
     *
     * @param LoginUserDto $userDto
     * @param Request $request
     *
     * @return void
     */
    public function accessToken(LoginUserDto $userDto, Request $request)
    {
        $response = new Psr7Response();

        try {
            $response = $this
                ->authorizationServer
                ->respondToAccessTokenRequest(
                    $this->makeAccessTokenRequest($request, $userDto->username, $userDto->password),
                    new Psr7Response()
                );
        } catch (OAuthServerException $e) {
            $response = $e->generateHttpResponse(new Psr7Response());
        }

        return $this->makeAccessTokenResponse($response);
    }

    /**
     * @param Request $request
     * @param string $username
     * @param string $password
     * @param string $scope
     *
     * @return ServerRequestInterface
     */
    private function makeAccessTokenRequest($request, $username, $password, $scope = '*')
    {
        $postData = [
            'grant_type' => 'password',
            'client_id' => 'ab7c51fb-4bb1-47c2-a577-ab9163374854',
            'client_secret' => $this->serverConfiguration->getAppSecret(),
            'scope' => $scope,
            'username' => $username,
            'password' => $password
        ];

        $psr17Factory = new Psr17Factory();
        $psrHttpFactory = new PsrHttpFactory($psr17Factory, $psr17Factory, $psr17Factory, $psr17Factory);
        $symfonyRequest = $request->duplicate(null, $postData);

        return $psrHttpFactory->createRequest($symfonyRequest);
    }

    /**
     * @param ResponseInterface $response
     *
     * @return Response
     */
    private function makeAccessTokenResponse($response)
    {
        $httpFoundationFactory = new HttpFoundationFactory();
        return $httpFoundationFactory->createResponse($response);
    }
}
