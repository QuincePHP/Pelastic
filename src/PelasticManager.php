<?php namespace Quince\Pelastic;

use Illuminate\Contracts\Config\PelasticConfigInterface;
use Illuminate\Contracts\Connection\Pool\ConnectionPoolInterface;
use Quince\Pelastic\Connection\Selector\PerRequestRoundRobinSelector;
use Quince\Pelastic\Exceptions\PelasticInvalidArgumentException;
use Quince\Pelastic\Exceptions\PelasticLogicException;

class PelasticManager {

    /**
     * Global config of the manager
     *
     * @var PelasticConfigInterface
     */
    protected static $config;

    /**
     * @var PelasticManager
     */
    protected static $instance;

    /**
     * @var ConnectionPoolInterface
     */
    protected $pool;

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
        $class = $this->getConfig()->getConnectionPoolStrategy();

        $this->pool = new $class($this->getSelector());

        if (!is_a($this->pool, $interface = ConnectionPoolInterface::class)) {
            throw new PelasticInvalidArgumentException("You have selected an invalid connection pool all pools should implement the [$interface] interface.");
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
}