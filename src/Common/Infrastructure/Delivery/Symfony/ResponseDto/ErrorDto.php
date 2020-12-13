<?php

namespace App\Common\Infrastructure\Delivery\Symfony\ResponseDto;


class ErrorDto
{
    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $detail;

    /**
     * @var array
     */
    private $source;

    /**
     * @var int
     */
    private $code;

    /**
     * ErrorDto Constructor
     *
     * @param string $title
     * @param string $detail
     * @param array $source
     * @param int $code
     */
    public function __construct($title, $detail, $source = '', $code = null)
    {
        $this->title = $title;
        $this->detail = $detail;
        $this->source = $source;
        $this->code = $code;
    }

    /**
     * @return  string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return  string
     */
    public function getDetail()
    {
        return $this->detail;
    }

    /**
     * @return  array
     */
    public function getSource()
    {
        return $this->source;
    }

    /**
     * @return int|null
     */
    public function getCode()
    {
        return $this->code;
    }
}
