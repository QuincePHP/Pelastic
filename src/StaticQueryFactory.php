<?php namespace Quince\Pelastic;

use Quince\Pelastic\Exceptions\PelasticInvalidArgumentException;
use Quince\Pelastic\Contracts\Queries\QueryInterface;
use Quince\Pelastic\Contracts\StaticQueryFactoryInterface;

class StaticQueryFactory extends StaticFactory implements StaticQueryFactoryInterface {

    /**
     * @var string
     */
    protected static $globalInterface = QueryInterface::class;

    /**
     * Creates the factory object of the given class with given arguments
     *
     * @param string $class
     * @param array  $args
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
     * @param array  $args
     * @return QueryInterface
     */
    public static function create($what, array $args = [])
    {
        try {

            return static::createFromClass(static::getClassNameFromKeyword($what), $args);

        } catch (PelasticInvalidArgumentException $e) {

            $eMessage = $e->getMessage();

            $message = "The class created from keyword : [{$what}] is not of type [QueryInterface] : {$eMessage}";

            throw new PelasticInvalidArgumentException($message);

        }
    }

    /**
     * Create a class name from the given keyword
     *
     * @param string $keyword
     * @return string
     */
    protected static function getClassNameFromKeyword($keyword)
    {
        $keyword = static::makeStudly($keyword);

        return rtrim(__NAMESPACE__, "\\") . "\\Queries\\" . $keyword . 'Query';
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
