<?php


namespace App\Common\Application\Bus;


use Exception;

class CommandNotFoundException extends Exception
{
    /**
     * CommandNotFoundException constructor.
     *
     * @param $command
     */
    public function __construct($command)
    {
        parent::__construct(sprintf('Unable to find a command for "%s"', $command), 0, null);
    }

}