<?php


namespace App\Shopsy\IdentityAccess\Main\Infrastructure\Domain\Service\Authentication\OAuth2;


use Nyholm\Psr7\Factory\Psr17Factory;
use Nyholm\Psr7\Response as Psr7Response;
use Psr\Http\Message\ServerRequestInterface;
use League\OAuth2\Server\AuthorizationServer;
use Symfony\Component\HttpFoundation\Request;
use App\Common\Infrastructure\ServerConfiguration;
use League\OAuth2\Server\Exception\OAuthServerException;
use Symfony\Bridge\PsrHttpMessage\Factory\PsrHttpFactory;
use App\Shopsy\IdentityAccess\Main\Domain\Model\Identity\UserId;
use App\Shopsy\IdentityAccess\Main\Domain\Service\Authentication;
use App\Shopsy\IdentityAccess\Main\Domain\Model\Identity\UserEmail;
use App\Shopsy\IdentityAccess\Main\Domain\Model\Identity\UserPassword;
use App\Shopsy\IdentityAccess\Main\Domain\Model\Identity\UserUsername;
use App\Shopsy\IdentityAccess\Main\Domain\Model\Identity\UserRepository;

class OAuth2Authentication extends Authentication
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @var ServerConfiguration
     */
    private $serverConfiguration;

    /**
     * @var AuthorizationServer
     */
    private $authorizationServer;

    /**
     * OAuth2Authentication constructor.
     *
     * @param UserRepository $userRepository
     * @param AuthorizationServer $authorizationServer
     */
    public function __construct(UserRepository $userRepository, ServerConfiguration $serverConfiguration, AuthorizationServer $authorizationServer)
    {
        $this->userRepository = $userRepository;
        $this->serverConfiguration = $serverConfiguration;
        $this->authorizationServer = $authorizationServer;
    }

    /**
     * @inheritDoc
     */
    protected function authenticateByUsername(UserUsername $userUsername, UserPassword $userPassword)
    {
        $user = $this->userRepository->findByUsername($userUsername);
        // TODO: handle user not found
        $response = $this->respondToAccessTokenRequest($user->getUsername(), $userPassword);
    }

    /**
     * @inheritDoc
     */
    protected function authenticateByEmail(UserEmail $userEmail, UserPassword $userPassword)
    {
        $user = $this->userRepository->findByEmail($userEmail);
        // TODO: handle user not found
        $response = $this->respondToAccessTokenRequest($user->getUsername(), $userPassword);
    }

    /**
     * @inheritDoc
     */
    protected function authenticateById(UserId $userId)
    {
        $user = $this->userRepository->findById($userId);
        // TODO: handle user not found

        // TODO: this will not work because we are passing already encrypted pw
        $response = $this->respondToAccessTokenRequest($user->getUsername(), $user->getPassword());
    }

    /**
     * @inheritDoc
     */
    private function respondToAccessTokenRequest($username, $password)
    {
        try {
            $response = $this
                ->authorizationServer
                ->respondToAccessTokenRequest(
                    $this->makeAccessTokenRequest($username, $password),
                    new Psr7Response()
                );
        } catch (OAuthServerException $e) {
            var_dump($e->getMessage());

            $response = $e->generateHttpResponse(new Psr7Response());
        }
        //TODO: convert psr7 response from League Oauth2 server to AuthResponse
        var_dump((string)$response->getBody());
        dd($response);
    }

    /**
     * @param Request $request
     * @param string $username
     * @param string $password
     * @param string $scope
     *
     * @return ServerRequestInterface
     */
    private function makeAccessTokenRequest($username, $password, $scope = '*')
    {
        // TODO: Get active password credentials client
        $postData = [
            'grant_type' => 'password',
            'client_id' => 'f00512e0-60f2-4585-aaad-db8b07f42248',
            'client_secret' => $this->serverConfiguration->getAppSecret(),
            'scope' => $scope,
            'username' => $username,
            'password' => $password
        ];

        $psr17Factory = new Psr17Factory();
        $psrHttpFactory = new PsrHttpFactory($psr17Factory, $psr17Factory, $psr17Factory, $psr17Factory);
        $symfonyRequest = new Request([], $postData, [], [], [], $_SERVER);

        return $psrHttpFactory->createRequest($symfonyRequest);
    }
}
