<?php

namespace App\Shopsy\IdentityAccess\Main\Infrastructure\Delivery\Symfony\Security;

use Nyholm\Psr7\Factory\Psr17Factory;
use League\OAuth2\Server\ResourceServer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\User\UserInterface;
use League\OAuth2\Server\Exception\OAuthServerException;
use Symfony\Bridge\PsrHttpMessage\Factory\PsrHttpFactory;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Bridge\PsrHttpMessage\Factory\HttpFoundationFactory;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;
use App\Common\Infrastructure\Delivery\Symfony\ResponseDto\ErrorDto;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use App\Shopsy\IdentityAccess\Main\Infrastructure\Delivery\Symfony\Exception\UnauthorizedHttpException;

class OAuth2Authenticator extends AbstractGuardAuthenticator
{
    /**
     * @var ResourceServer
     */
    private $resourceServer;

    /**
     * OAuth2Authenticator Constructor
     *
     * @param ResourceServer $resourceServer
     */
    public function __construct(ResourceServer $resourceServer)
    {
        $this->resourceServer = $resourceServer;
    }

    /**
     * @param Request $request
     *
     * @return bool
     */
    public function supports(Request $request)
    {
        return true;
    }

    /**
     * @param Request $request
     *
     * @return Request
     */
    public function getCredentials(Request $request)
    {
        return $request;
    }

    /**
     * @param Request $credentials
     * @param UserProviderInterface $userProvider
     *
     * @return void
     */
    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        /**
         * @var Request
         */
        $request = $this->validateAuthenticatedRequest($credentials);

        return $userProvider->loadUserByUsername($request->get('oauth_user_id'));
    }

    /**
     * @param mixed $credentials
     * @param UserInterface $user
     *
     * @return bool
     */
    public function checkCredentials($credentials, UserInterface $user)
    {
        return true;
    }

    /**
     * @param Request $request
     * @param TokenInterface $token
     * @param mixed $providerKey
     *
     * @return void
     */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        return null;
    }

    /**
     * @param Request $request
     * @param AuthenticationException $exception
     *
     * @return void
     */
    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        throw new UnauthorizedHttpException(
            new ErrorDto('Unauthorized', $exception->getMessage()),
            Response::HTTP_UNAUTHORIZED,
            $exception->getMessage(),
            $exception->getCode(),
            [],
            $exception->getPrevious()
        );
    }

    /**
     * @param Request $request
     * @param AuthenticationException $authException
     *
     * @return void
     */
    public function start(Request $request, AuthenticationException $authException = null)
    {
        throw new UnauthorizedHttpException(
            new ErrorDto('Unauthorized', $authException->getMessage()),
            Response::HTTP_UNAUTHORIZED,
            $authException->getMessage(),
            $authException->getCode(),
            [],
            $authException->getPrevious()
        );
    }

    /**
     * @return bool
     */
    public function supportsRememberMe()
    {
        return false;
    }

    /**
     * @param Request $request
     *
     * @return Request
     */
    private function validateAuthenticatedRequest($request)
    {
        $psr17Factory = new Psr17Factory();
        $psrHttpFactory = new PsrHttpFactory($psr17Factory, $psr17Factory, $psr17Factory, $psr17Factory);

        $symfonyRequest = $request->duplicate();

        $serverRequest = $psrHttpFactory->createRequest($symfonyRequest);

        try {
            $serverRequest = $this->resourceServer->validateAuthenticatedRequest($serverRequest);
        } catch (OAuthServerException $e) {
            throw new AuthenticationException($e->getMessage(), $e->getCode(), $e);
        }

        $httpFoundationFactory = new HttpFoundationFactory();
        $symfonyRequest = $httpFoundationFactory->createRequest($serverRequest);

        return $symfonyRequest;
    }
}
