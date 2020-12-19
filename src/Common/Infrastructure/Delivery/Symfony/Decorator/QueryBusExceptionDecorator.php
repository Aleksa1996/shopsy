<?php

namespace App\Common\Infrastructure\Delivery\Symfony\Decorator;

use App\Common\Application\Bus\Bus;
use App\Common\Application\ExceptionHandler;
use App\Common\Application\Bus\Query\QueryBus;

class QueryBusExceptionDecorator implements Bus
{
    /**
     * @var QueryBus
     */
    private $queryBus;

    /**
     * @var ExceptionHandler
     */
    private $exceptionHandler;

    /**
     * QueryBusExceptionDecorator Constructor
     *
     * @param QueryBus $queryBus
     */
    public function __construct(QueryBus $queryBus, ExceptionHandler $exceptionHandler)
    {
        $this->queryBus = $queryBus;
        $this->exceptionHandler = $exceptionHandler;
    }

    /**
     * @inheritDoc
     */
    public function handle($query)
    {
        try {
            return $this->queryBus->handle($query);
        } catch (\Exception $e) {
            $this->exceptionHandler->handle($e);
        }
    }
}
