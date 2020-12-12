<?php

namespace App\Common\Infrastructure\Delivery\Symfony\DependencyInjection\Compiler;

use App\Common\Application\Bus\Command\Middleware\HandlerMiddleware;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class RegisterCommandHandlerPass implements CompilerPassInterface
{
    /**
     * @inheritDoc
     */
    public function process(ContainerBuilder $container)
    {
        // always first check if the primary service is defined
        if (!$container->has(HandlerMiddleware::class)) {
            return;
        }

        $definition = $container->findDefinition(HandlerMiddleware::class);

        $taggedServices = $container->findTaggedServiceIds('app.command.handler');

        foreach ($taggedServices as $id => $tags) {
            $definition->addMethodCall('register', [new Reference($id)]);
        }
    }
}