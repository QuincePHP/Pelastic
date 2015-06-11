<?php namespace Quince\Pelastic\Contracts\Factories;

use Quince\Pelastic\Contracts\Filters\FilterInterface;
use Quince\Pelastic\Contracts\Queries\QueryInterface;

interface StaticFactoryInterface {

    /**
     * Creates the factory object of the given class with given arguments
     *
     * @param string $class
     * @param array  $args
     * @return QueryInterface|FilterInterface
     */
    public static function createFromClass($class, array $args = []);

    /**
     * Creates factory objects from keywords
     *
     * @param string $what
     * @param array  $args
     * @return QueryInterface|FilterInterface
     */
    public static function create($what, array $args = []);

    /**
     * Get interface which all given classes should implement that
     *
     * @return string
     */
    public static function getInterface();
}