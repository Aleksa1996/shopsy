<?php

namespace App\Common\Application\Bus\Query;


use ReflectionMethod;
use ReflectionException;
use App\Common\Application\Bus\Bus;
use App\Common\Application\Query\QueryHandler;
use App\Common\Application\Bus\HandlerNotFoundException;
use App\Common\Application\Query\ExceptionHandlingQueryHandler;
use App\Common\Application\Query\QueryExceptionHandler;

class QueryBus implements Bus
{
    /**
     * @var array
     */
    private $queryHandlers = [];

    /**
     * @param $query
     *
     * @throws HandlerNotFoundException
     */
    public function handle($command)
    {
        $queryClass = get_class($command);
        if (!isset($this->queryHandlers[$queryClass])) {
            throw new HandlerNotFoundException($queryClass);
        }

        $queryHandler = new ExceptionHandlingQueryHandler($this->queryHandlers[$queryClass], new QueryExceptionHandler());

        return $queryHandler->execute($command);
    }

    /**
     * @param QueryHandler $queryHandler
     *
     * @throws ReflectionException
     */
    public function register(QueryHandler $queryHandler)
    {
        $queryClass = $this->getQueryType($queryHandler);

        if (is_null($queryClass)) {
            throw new QueryNotFoundException($queryClass);
        }

        $this->queryHandlers[$queryClass] = $queryHandler;
    }

    /**
     * @param QueryHandler $queryHandler
     *
     * @return string
     *
     * @throws ReflectionException
     */
    private function getQueryType(QueryHandler $queryHandler)
    {
        $reflectionMethod = new ReflectionMethod(get_class($queryHandler), 'execute');
        $queryParameter = $reflectionMethod->getParameters()[0] ?? null;

        if (is_null($queryParameter)) {
            return $queryHandler;
        }

        return $queryParameter->getClass()->getName();
    }
}
