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
     *  ServerConfiguration Constructor
     *
     * @param RouterInterface $router
     */
    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
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
     * @return string
     */
    public function getHostname()
    {
        return $_ENV['APP_HOST_NAME'];
    }
}
