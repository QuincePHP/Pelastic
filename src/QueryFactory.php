<?php namespace Quince\Pelastic;

use Quince\Pelastic\Contracts\Queries\QueryInterface;
use Quince\Pelastic\Contracts\QueryFactorInterface;

class QueryFactory implements QueryFactorInterface {

    /**
     * Creates the factory object of the given class with given arguments
     *
     * @param $class
     * @param array $args
     * @return QueryInterface
     */
    public function createFromClass($class, array $args = [])
    {
        return StaticQueryFactory::createFromClass($class, $args);
    }

    /**
     * Creates factory objects from keywords
     *
     * @param $what
     * @param array $args
     * @return QueryInterface
     */
    public function create($what, array $args = [])
    {
        return StaticQueryFactory::create($what, $args);
    }

    /**
     * Forward calls to the static factory
     *
     * @param $method
     * @param array $args
     * @return QueryInterface
     */
    public function __call($method, array $args = [])
    {
        return forward_static_call_array([StaticQueryFactory::class, $method], $args);
    }
}