<?php namespace Quince\Pelastic\Factories;

use Quince\Pelastic\Contracts\Factories\QueryFactoryInterface;
use Quince\Pelastic\Contracts\Queries\QueryInterface;

class QueryFactory implements QueryFactoryInterface {

    /**
     * Creates the factory object of the given class with given arguments
     *
     * @param string $class
     * @param array  $args
     * @return QueryInterface
     */
    public function createFromClass($class, array $args = [])
    {
        return StaticQueryFactory::createFromClass($class, $args);
    }

    /**
     * Creates factory objects from keywords
     *
     * @param string $what
     * @param array  $args
     * @return QueryInterface
     */
    public function create($what, array $args = [])
    {
        return StaticQueryFactory::create($what, $args);
    }

    /**
     * Forward calls to the static factory
     *
     * @param string $method
     * @param array  $args
     * @return QueryInterface
     */
    public function __call($method, array $args = [])
    {
        return forward_static_call_array([StaticQueryFactory::class, $method], $args);
    }

    /**
     * Get interface that all created classes by factory should implement
     *
     * @return string
     */
    public function getInterface()
    {
        return StaticQueryFactory::getInterface();
    }
}
