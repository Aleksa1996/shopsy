<?php


namespace App\Shared\Application\Service;


interface ApplicationService
{
    /**
     * @param ApplicationRequest|null $request
     *
     * @return mixed
     */
    public function execute(ApplicationRequest $request = null);
}