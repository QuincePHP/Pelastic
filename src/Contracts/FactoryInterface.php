<?php namespace Quince\Pelastic\Contracts;

use Quince\Pelastic\Contracts\Filters\FilterInterface;
use Quince\Pelastic\Contracts\Queries\QueryInterface;

interface FactoryInterface {

    /**
     * Creates the factory object of the given class with given arguments
     *
     * @param string $class
     * @param array  $args
     * @return QueryInterface|FilterInterface
     */
    public function createFromClass($class, array $args = []);

    /**
     * Creates factory objects from keywords
     *
     * @param string $what
     * @param array  $args
     * @return QueryInterface|FilterInterface
     */
    public function create($what, array $args = []);

    /**
     * Get interface that all created classes by factory should implement
     *
     * @return string
     */
    public function getInterface();

}