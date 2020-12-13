<?php

namespace App\Common\Application\Bus\Command;

interface Middleware
{
    /**
     * @param object $command
     * @param callable $next
     *
     * @return mixed
     */
    public function execute(object $command, callable $next);
}
