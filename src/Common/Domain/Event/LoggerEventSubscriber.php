<?php

namespace App\Common\Domain\Event;

use App\Common\Domain\Event\DomainEventSubscriber;

class LoggerEventSubscriber implements DomainEventSubscriber
{
    /**
     * @inheritDoc
     */
    public function handle($aDomainEvent)
    {
        try {
            // var_dump(get_class($aDomainEvent));
        } catch (\Exception $e) {
        }
    }

    /**
     * @inheritDoc
     */
    public function isSubscribedTo($aDomainEvent)
    {
        return true;
    }
}
