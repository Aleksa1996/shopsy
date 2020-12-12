<?php

namespace App\Common\Application\Bus\Query;


use ReflectionMethod;
use ReflectionException;
use App\Common\Application\Query\QueryHandler;
use App\Common\Application\Bus\HandlerNotFoundException;

class QueryBus
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
    public function handle($query)
    {
        $queryClass = get_class($query);
        if (!isset($this->queryHandlers[$queryClass])) {
            throw new HandlerNotFoundException($queryClass);
        }

        $queryHandler = $this->queryHandlers[$queryClass];

        return $queryHandler->execute($query);
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
