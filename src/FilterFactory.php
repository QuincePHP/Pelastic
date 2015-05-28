<?php namespace Quince\Pelastic;

use Quince\Pelastic\Contracts\FilterFactoryInterface;
use Quince\Pelastic\Contracts\Queries\QueryInterface;

class FilterFactory implements FilterFactoryInterface {

    /**
     * Creates the factory object of the given class with given arguments
     *
     * @param string $class
     * @param array $args
     * @return QueryInterface
     */
    public function createFromClass($class, array $args = [])
    {
        return StaticFilterFactory::createFromClass($class, $args);
    }

    /**
     * Creates factory objects from keywords
     *
     * @param string $what
     * @param array $args
     * @return QueryInterface
     */
    public function create($what, array $args = [])
    {
        return StaticFilterFactory::create($what, $args);
    }

    /**
     * Forward static call to static factory
     *
     * @param $method
     * @param array $args
     * @return QueryInterface
     */
    public function __call($method, array $args = [])
    {
        return forward_static_call_array([StaticFilterFactory::class, $method], $args);
    }
}