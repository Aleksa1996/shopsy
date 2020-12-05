<?php


namespace App\Shopsy\IdentityAccess\Main\Infrastructure\Domain\Service\Authentication\OAuth2;


use App\Shopsy\IdentityAccess\Main\Domain\Model\User\User;
use App\Shopsy\IdentityAccess\Main\Domain\Model\User\UserRepository;
use App\Shopsy\IdentityAccess\Main\Domain\Service\Authentication;
use League\OAuth2\Server\AuthorizationServer;
use League\OAuth2\Server\Exception\OAuthServerException;
use Nyholm\Psr7\Factory\Psr17Factory;
use Nyholm\Psr7\Response as Psr7Response;
use Nyholm\Psr7Server\ServerRequestCreator;
use Psr\Http\Message\ServerRequestInterface;


class OAuth2Authentication extends Authentication
{

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
    public function __construct(UserRepository $userRepository, AuthorizationServer $authorizationServer)
    {
        parent::__construct($userRepository);
        $this->authorizationServer = $authorizationServer;
    }

    /**
     * @inheritDoc
     */
    protected function isAlreadyAuthenticated()
    {
        // TODO: Implement isAlreadyAuthenticated() method.
    }

    /**
     * @inheritDoc
     *
     * @throws OAuthServerException
     */
    protected function auth($usernameOrEmail, $password, $user)
    {
        $response = $this->authorizationServer->respondToAccessTokenRequest(
            $this->makeServerRequest((string)$usernameOrEmail, (string)$password),
            new Psr7Response()
        );

        var_dump((string)$response->getBody());

        return true;
    }

    /**
     * @inheritDoc
     */
    public function logout()
    {
        // TODO: Implement logout() method.
    }

    /**
     * @inheritDoc
     */
    protected function persistAuthentication(User $user)
    {
        // TODO: Implement persistAuthentication() method.
    }

    /**
     * @param $usernameOrEmail
     * @param $password
     * @param string $scope
     *
     * @return ServerRequestInterface
     */
    private function makeServerRequest($usernameOrEmail, $password, $scope = '*')
    {
        $post = [
            'grant_type' => 'password',
            'client_id' => 'resource_owner_password_credentials_grant',
            'client_secret' => 'resource_owner_password_credentials_grant',
            'scope' => $scope,
            'username' => $usernameOrEmail,
            'password' => $password
        ];

        $psr17Factory = new Psr17Factory();
        $serverRequestCreator = new ServerRequestCreator(
            $psr17Factory, // ServerRequestFactory
            $psr17Factory, // UriFactory
            $psr17Factory, // UploadedFileFactory
            $psr17Factory  // StreamFactory
        );

        return $serverRequestCreator
            ->fromArrays(
                ['REQUEST_METHOD' => 'POST'],
                ['Content-Type' => 'application/json'],
                [],
                [],
                $post,
                []
            );
    }
}