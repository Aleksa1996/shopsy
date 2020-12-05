<?php

namespace App\Common\Application\Bus;

use Exception;

class HandlerNotFoundException extends Exception
{
    /**
     * HandlerNotFoundException constructor.
     *
     * @param $command
     */
    public function __construct($command)
    {
        parent::__construct(sprintf('Unable to find a registered handler for "%s"', $command), 0, null);
    }
}