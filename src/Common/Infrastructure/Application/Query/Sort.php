<?php

namespace App\Common\Infrastructure\Application\Query;


class Sort
{
    /**
     * @var array
     */
    protected $fields;

    /**
     * @var array
     */
    public const ORDER = [
        '-' => 'desc',
        '+' => 'asc'
    ];

    /**
     * Sort constructor
     *
     * @param array $fields
     */
    public function __construct(array $fields)
    {
        $this->fields = $fields;
    }

    /**
     * @return  array
     */
    public function getFields()
    {
        return $this->fields;
    }

    /**
     * @return self
     */
    public static function create($sort)
    {
        if (is_array($sort)) {
            return new self($sort);
        }

        $fields = [];

        if (!is_string($sort)) {
            return new self($fields);
        }

        $explodedFields = explode(',', $sort);

        foreach ($explodedFields as $field) {
            $trimmedField = ltrim($field, '+-');

            foreach (self::ORDER as $orderKey => $order) {
                if (strpos($field, $orderKey) === 0) {
                    $fields[$trimmedField] = $order;
                    break;
                }
            }

            if (!isset($fields[$trimmedField])) {
                $fields[$trimmedField] = self::ORDER['+'];
            }
        }

        return new self($fields);
    }
}
