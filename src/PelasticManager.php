<?php namespace Quince\Pelastic;

use Illuminate\Contracts\Config\PelasticConfigInterface;
use Illuminate\Contracts\Connection\Pool\ConnectionPoolInterface;
use Quince\Pelastic\Connection\Selector\PerRequestRoundRobinSelector;
use Quince\Pelastic\Exceptions\PelasticInvalidArgumentException;
use Quince\Pelastic\Exceptions\PelasticLogicException;
use Quince\Pelastic\Filters\BooleanFilter;
use Quince\Pelastic\Queries\BooleanQuery;
use Quince\Pelastic\SqlMonkey\QueryBuilder;

class PelasticManager {

    /**
     * Global config of the manager which is given by user, things like hosts
     * needed selector strategies and son
     *
     * @var PelasticConfigInterface
     */
    protected static $config;

    /**
     * This class is like a facade or a proxy to other features of Pelastic
     * as we haven't used any dependency container strategy because of its performance
     * overhead.
     *
     * @var PelasticManager
     */
    protected static $instance;

    /**
     * The global connection pool all of the connection instance are provided by this pool
     *
     * @var ConnectionPoolInterface
     */
    protected $pool;

    /**
     * Get singleton instance of the class
     *
     * @return PelasticManager
     */
    public static function getInstance()
    {
        if (null === static::getConfig()) {
            throw new PelasticLogicException("Entity manager can not work without a config instance");
        }

        if (null === (static::$instance)) {

            // We simply bootstrap our needed dependencies after instantiating the object
            static::$instance = new static();
            static::$instance->bootstrap();

        }

        return static::$instance;
    }

    /**
     * Bootstrap needed things
     */
    protected function bootstrap()
    {
        // The config provided by the user contains of two important parts
        // firs a Selector "object" which is called by connection pool
        // to select a connection from an array of collections with different strategies
        // like round robin
        $class = $this->getConfig()->getConnectionPoolStrategy();

        if (!is_object($class)) {
            $this->pool = new $class($this->getSelector());
        }else {
            $this->pool = $class;
        }

        // We simply make sure that the given pool is from our interface
        if (!is_a($this->pool, $interface = ConnectionPoolInterface::class)) {
            throw new PelasticInvalidArgumentException(
                "You have selected an invalid connection pool all pools should implement the [$interface] interface."
            );
        }
    }

    /**
     * Set global config of the class
     *
     * @param PelasticConfigInterface $config
     * @return void
     */
    public static function setConfig(PelasticConfigInterface $config)
    {
        static::$config = $config;
    }

    /**
     * Get config instance
     *
     * @return PelasticConfigInterface
     */
    public static function getConfig()
    {
        return static::$config;
    }

    /**
     * Get selector which is going to be used
     *
     * @return $this
     */
    public function getSelector()
    {
        // If we have not set the selector in config section we will set it now.
        if (null === $selector = $this->getConfig()->getSelector()) {
            $selector = $this->getConfig()->setSelector(new PerRequestRoundRobinSelector());
        }

        return $selector;
    }

    /**
     * Get connection pool
     *
     * @return ConnectionPoolInterface
     */
    public function getPool()
    {
        return $this->pool;
    }

    /**
     * Get sql monkey
     *
     * @return QueryBuilder
     */
    public function getSqlMonkey()
    {
        return new QueryBuilder(
            $this,
            new BooleanFilter(),
            new BooleanQuery()
        );
    }

    /**
     * Prevent un-serialize
     */
    protected function __wakeup() {}

    /**
     * Prevent cloning
     */
    protected function __clone() {}

    /**
     * Prevent new
     */
    protected function __construct() {}
}