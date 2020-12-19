<?php

namespace App\Common\Application\Query;

use App\Common\Application\Query\QueryException;
use App\Common\Application\ExceptionHandler;

class QueryExceptionHandler implements ExceptionHandler
{
    /**
     * @inheritDoc
     */
    public function handle(\Exception $e)
    {
        if ($e instanceof QueryException) {
            throw $e;
        }

        throw new QueryException('Internal Error', 'Query failed to execute', [], $e->getMessage(), $e->getCode(), $e->getPrevious());
    }
}
