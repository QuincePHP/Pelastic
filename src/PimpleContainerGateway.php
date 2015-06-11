<?php namespace Quince\Pelastic;

use Pimple\Container;
use Quince\Pelastic\Contracts\PimpleContainerGatewayInterface;
use Symfony\Component\EventDispatcher\EventDispatcher;

class PimpleContainerGateway implements PimpleContainerGatewayInterface {

    /**
     * @var array
     */
    protected static $sharedBinds = [
        'event_dispatcher' => EventDispatcher::class,
    ];

    /**
     * @var Container
     */
    protected static $sharedContainer;

    /**
     * Get the pimple container
     *
     * @return Container
     */
    public static function getContainer()
    {
        return static::$sharedContainer ?: static::$sharedContainer = static::createContainer();
    }

    /**
     * Create Pimple Container
     *
     * @return Container
     */
    protected static function createContainer()
    {
        $container = new Container();

        static::addDefaultBindings($container);

        return $container;
    }

    /**
     * Add default bindings to the global container
     *
     * @param Container $container
     * @return Container
     */
    protected static function addDefaultBindings(Container $container)
    {
        foreach (static::getSharedBinds() as $key => $bindable) {
            $container[$key] = function() use($bindable) {
                return new $bindable;
            };
        }

        return $container;
    }

    /**
     * Get shared bindings
     *
     * @return array
     */
    public static function getSharedBinds()
    {
        return static::$sharedBinds;
    }
}