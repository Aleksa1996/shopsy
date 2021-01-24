<?php

namespace App\Common\Domain\Event\Facade;

use Indragunawan\FacadeBundle\AbstractFacade;

class DomainEventPublisher extends AbstractFacade
{
    /**
     * @inheritDoc
     */
    protected static function getFacadeAccessor()
    {
        return 'App\Common\Domain\Event\DomainEventPublisher';
    }
}
