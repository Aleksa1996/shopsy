<?php

namespace App\Common\Application;


interface ExceptionHandler
{
    /**
     * @param \Exception $e
     *
     * @return void
     */
    public function handle(\Exception $e);
}
