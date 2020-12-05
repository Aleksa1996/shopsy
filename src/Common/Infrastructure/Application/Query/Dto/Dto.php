<?php

namespace App\Common\Infrastructure\Application\Query\Dto;


abstract class Dto
{
    /**
     * @return int|string
     */
    public abstract function getId();
}
