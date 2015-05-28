<?php namespace Quince\Pelastic;

use Quince\Pelastic\Contracts\Queries\QueryInterface;
use Stringy\StaticStringy;

class StaticFilterFactory extends StaticStringy implements StaticFilterFactoryInterface {

    /**
     * Creates the factory object of the given class with given arguments
     *
     * @param string $class
     * @param array $args
     * @return QueryInterface
     */
    public static function createFromClass($class, array $args = [])
    {
        // TODO: Implement createFromClass() method.
    }

    /**
     * Creates factory objects from keywords
     *
     * @param string $what
     * @param array $args
     * @return QueryInterface
     */
    public static function create($what, array $args = [])
    {
        // TODO: Implement create() method.
    }
}