<?php namespace Quince\Pelastic;

use Quince\Exceptions\PelasticInvalidArgumentException;
use Quince\Pelastic\Contracts\Queries\QueryInterface;
use Quince\Pelastic\Contracts\StaticQueryFactoryInterface;
use Stringy\StaticStringy;

class StaticQueryFactory implements StaticQueryFactoryInterface {

    /**
     * Creates the factory object of the given class with given arguments
     *
     * @param $class
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
     * @param $what
     * @param array $args
     * @return QueryInterface
     */
    public static function create($what, array $args = [])
    {
        try {

            return static::createFromClass(static::getClassNameFromKeyword($what), $args);

        } catch(PelasticInvalidArgumentException $e) {

            $eMessage = $e->getMessage();

            $message = "The class created from keyword : [{$what}] is not of type [QueryInterface] : {$eMessage}";

            throw new PelasticInvalidArgumentException($message);

        }
    }

    /**
     * Create a class name from the given keyword
     *
     * @param $keyword
     * @return string
     */
    protected static function getClassNameFromKeyword($keyword)
    {
        $keyword = ucfirst(StaticStringy::camelize($keyword));

        return rtrim(__NAMESPACE__, "\\") . "\\Queries\\" . $keyword . 'Query';
    }

    /**
     * Creates class with reflection given some args
     *
     * @param $class
     * @param array $args
     * @return object
     */
    protected static function makeClassByReflection($class, array $args)
    {
        $reflectionClass = new \ReflectionClass($class);

        if (!$reflectionClass->implementsInterface(QueryInterface::class)) {

            throw new PelasticInvalidArgumentException("Given class name does not implement the QueryInterface.");

        }

        return $reflectionClass->newInstanceArgs($args);
    }

    /**
     * @param $class
     * @return QueryInterface
     */
    protected static function makeClass($class)
    {
        return new $class;
    }
}