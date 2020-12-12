<?php


namespace App\Common\Application\Bus\Query;


use Exception;

class QueryNotFoundException extends Exception
{
    /**
     * QueryNotFoundException constructor.
     *
     * @param $command
     */
    public function __construct($command)
    {
        parent::__construct(sprintf('Unable to find a query for "%s"', $command), 0, null);
    }

}