<?php

namespace App\Common\Infrastructure;

use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;

class ServerConfiguration
{
    /**
     * @var RouterInterface
     */
    private $router;

    /**
     * @var ContainerBagInterface
     */
    private $params;

    /**
     * ServerConfiguration Constructor
     *
     * @param RouterInterface $router
     * @param string $kernelProjectDir
     * @param string $appSecret
     * @param string $appHostname
     * @param bool $appSSLEnabled
     */
    public function __construct(RouterInterface $router, ContainerBagInterface $params)
    {
        $this->router = $router;
        $this->params = $params;
    }

    /**
     * @param string $name
     * @param array $parameters
     * @param integer $referenceType
     *
     * @return string
     */
    public function generateUrl(string $name, array $parameters = [], int $referenceType = UrlGeneratorInterface::ABSOLUTE_PATH)
    {
        return sprintf('%s://%s%s', $this->getScheme(), $this->getHostname(), $this->router->generate($name, $parameters, $referenceType));
    }

    /**
     * @return string
     */
    public function getKernelProjectDir()
    {
        return $this->params->get('kernel.project_dir');
    }

    /**
     * @return string
     */
    public function getAppSecret()
    {
        return $_ENV['APP_SECRET'] ?? null;
    }

    /**
     * @return string
     */
    public function getHostname()
    {
        return $_ENV['APP_HOSTNAME'] ?? null;
    }

    /**
     * @return boolean
     */
    public function isSslEnabled()
    {
        return  filter_var($_ENV['APP_SSL_ENABLED'], FILTER_VALIDATE_BOOLEAN);
    }

    /**
     * @return string
     */
    public function getScheme()
    {
        return $this->isSslEnabled() ? 'https' : 'http';
    }

    /**
     * @param string $key
     * @param mixed $default
     *
     * @return mixed
     */
    public function getEnv($key, $default = null)
    {
        return $_ENV[$key] ?? $default;
    }
}
