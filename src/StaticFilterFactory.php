<?php namespace Quince\Pelastic;

use Quince\Pelastic\Contracts\Filters\FilterInterface;
use Quince\Pelastic\Contracts\Queries\QueryInterface;

class StaticFilterFactory extends StaticFactory implements StaticFilterFactoryInterface {

    protected $globalInterface = FilterInterface::class;

    /**
     * Creates the factory object of the given class with given arguments
     *
     * @param string $class
     * @param array $args
     * @return QueryInterface
     */
    public static function createFromClass($class, array $args = [])
    {
        return static::makeClassByReflection($class, $args);
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
        $class = static::makeStudly($what);

        $class = rtrim(__NAMESPACE__, "\\") . "\\Filters\\" . $class . 'Filter';

        return self::createFromClass($class, $args);
    }

    /**
     * Get interface which all given classes should implement that
     *
     * @return string
     */
    public static function getInterface()
    {
        return static::getInterfaceFromProperty();
    }
}