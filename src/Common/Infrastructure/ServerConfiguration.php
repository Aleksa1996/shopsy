<?php

namespace App\Common\Infrastructure;

use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class ServerConfiguration
{
    /**
     * @var RouterInterface
     */
    private $router;

    /**
     * @var string
     */
    private $kernelProjectDir;

    /**
     * @var string
     */
    private $appSecret;

    /**
     * @var string
     */
    private $appHostname;

    /**
     * @var string
     */
    private $appSSLEnabled;

    /**
     * ServerConfiguration Constructor
     *
     * @param RouterInterface $router
     * @param string $kernelProjectDir
     * @param string $appSecret
     * @param string $appHostname
     * @param bool $appSSLEnabled
     */
    public function __construct(RouterInterface $router, $kernelProjectDir, $appSecret, $appHostname, $appSSLEnabled)
    {
        $this->router = $router;
        $this->kernelProjectDir = $kernelProjectDir;
        $this->appSecret = $appSecret;
        $this->appHostname = $appHostname;
        $this->appSSLEnabled = $appSSLEnabled;
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
        return $this->kernelProjectDir;
    }

    /**
     * @return string
     */
    public function getAppSecret()
    {
        return $this->appSecret;
    }

    /**
     * @return string
     */
    public function getHostname()
    {
        return $this->appHostname;
    }

    /**
     * @return boolean
     */
    public function isSslEnabled()
    {
        return  filter_var($this->appSSLEnabled, FILTER_VALIDATE_BOOLEAN);
    }

    /**
     * @return string
     */
    public function getScheme()
    {
        return $this->isSslEnabled() ? 'https' : 'http';
    }
}
