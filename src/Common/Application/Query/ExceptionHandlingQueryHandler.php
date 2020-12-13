<?php

namespace App\Common\Application\Query;

use App\Common\Application\ExceptionHandler;
use App\Common\Application\Query\QueryHandler;

class ExceptionHandlingQueryHandler implements QueryHandler
{
    /**
     * @var QueryHandler
     */
    private $queryHandler;

    /**
     * @var ExceptionHandler
     */
    private $exceptionHandler;

    /**
     * ExceptionHandlingMiddleware constructor.
     *
     * @param ExceptionHandler  $exceptionHandler
     */
    public function __construct(QueryHandler $queryHandler, ExceptionHandler $exceptionHandler)
    {
        $this->queryHandler = $queryHandler;
        $this->exceptionHandler = $exceptionHandler;
    }

    /**
     * @param mixed $query
     *
     * @return void
     */
    public function execute($query)
    {
        try {
            return $this->queryHandler->execute($query);
        } catch (\Exception $e) {
            $this->exceptionHandler->handle($e);
        }
    }
}
