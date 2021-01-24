<?php

namespace App\Common\Infrastructure\Delivery\Symfony\DependencyInjection\Compiler;

use App\Common\Domain\Event\DomainEventPublisher;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;

class RegisterEventSubscriberPass implements CompilerPassInterface
{
    /**
     * @inheritDoc
     */
    public function process(ContainerBuilder $container)
    {
        // always first check if the primary service is defined
        if (!$container->has(DomainEventPublisher::class)) {
            return;
        }

        $definition = $container->findDefinition(DomainEventPublisher::class);

        $taggedServices = $container->findTaggedServiceIds('app.domain.event.subscriber');

        foreach ($taggedServices as $id => $tags) {
            $definition->addMethodCall('subscribe', [new Reference($id)]);
        }

    }
}
