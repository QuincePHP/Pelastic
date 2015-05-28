<?php namespace Quince\Pelastic\Queries;

use Quince\Pelastic\Contracts\ArrayableInterface;
use Quince\Pelastic\Contracts\Queries\QueryInterface;

class QueryManager {

    /**
     * Creates a new applyable query
     *
     * @param QueryInterface|ArrayableInterface $queryInterface
     * @return array
     */
    public function create(QueryInterface $queryInterface)
    {
        return static::staticCreate($queryInterface);
    }

    /**
     * Creates a new applyable query
     *
     * @param QueryInterface|ArrayableInterface $queryInterface
     * @return array
     */
    public static function staticCreate(QueryInterface $queryInterface)
    {
        return [
            "query" => $queryInterface->toArray()
        ];
    }

}