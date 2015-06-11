<?php namespace Quince\Pelastic\Factories;

use Quince\Pelastic\Contracts\Factories\StaticFactoryInterface;
use Quince\Pelastic\Exceptions\PelasticInvalidArgumentException;
use Quince\Pelastic\Exceptions\PelasticLogicException;
use Stringy\StaticStringy;

abstract class StaticFactory implements StaticFactoryInterface {

    /**
     * The global interface the factory creates it's implementation
     *
     * @var string
     */
    protected static $globalInterface;

    /**
     * Make string studly
     *
     * @param $string
     * @return string
     */
    public static function makeStudly($string)
    {
        return ucfirst(StaticStringy::camelize($string));
    }

    /**
     * Creates class with reflection given some args
     *
     * @param string $class
     * @param array $args
     * @return object
     * @throws PelasticInvalidArgumentException
     */
    protected static function makeClassByReflection($class, array $args)
    {
        $reflectionClass = new \ReflectionClass($class);

        if (!$reflectionClass->implementsInterface($interface = static::getInterface())) {

            throw new PelasticInvalidArgumentException("Given class name must implement the [$interface].");

        }

        return $reflectionClass->newInstanceArgs($args);
    }

    /**
     * Get the global interface which a factory is supposed to create its implementation
     *
     * @return string
     */
    protected static function getInterfaceFromProperty()
    {
        if (static::$globalInterface === null) {

           throw new PelasticLogicException("You should set an interface for a factory class to make it able create its implementation");

        }

        return static::$globalInterface;
    }
}