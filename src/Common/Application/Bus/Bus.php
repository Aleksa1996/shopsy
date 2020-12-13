<?php

namespace App\Common\Application\Bus;


interface Bus
{
    /**
     * @param mixed $command
     *
     * @return void|mixed
     */
    public function handle($command);
}
