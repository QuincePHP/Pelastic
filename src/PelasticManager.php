<?php namespace Quince\Pelastic;

use Illuminate\Contracts\Config\PelasticConfigInterface;
use Quince\Pelastic\Contracts\Api\RepositoryInterface;
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
     * Prevent un-serialize
     */
    protected function __wakeup() {}

    /**
     * Prevent cloning
     */
    protected function __clone() {}

    /**
     * Get singleton instance of the class
     *
     * @return PelasticManager
     */
    public function getInstance()
    {
        if (null === static::getConfig()) {
            throw new PelasticLogicException("Entity manager can not work without a config instance");
        }

        if (null === (static::$instance)) {
            static::$instance = new static();
        }

        return static::$instance;
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
    
}