<?php namespace Quince\Pelastic\Contracts;

use Quince\Pelastic\Contracts\Queries\QueryInterface;

interface QueryFactorInterface {

    /**
     * Creates the factory object of the given class with given arguments
     *
     * @param $class
     * @param array $args
     * @return QueryInterface
     */
    public function createFromClass($class, array $args = []);

    /**
     * Creates factory objects from keywords
     *
     * @param $what
     * @param array $args
     * @return QueryInterface
     */
    public function create($what, array $args = []);

}