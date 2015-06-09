<?php namespace Quince\Pelastic\Config;

use Quince\Pelastic\Contracts\Config\PelasticConfigInterface;
use Quince\Pelastic\Exceptions\PelasticInvalidArgumentException;

class PelasticConfig implements  PelasticConfigInterface {

    /**
     * Available auth methods
     *
     * @var array
     */
    protected $authMethods = [
        'Basic'
    ];

    /**
     * Global config array
     *
     * @var array
     */
    protected $config;

    /**
     * Set hosts to be used to init connections
     *
     * @param array $hosts
     * @return $this
     */
    public function setHosts(array $hosts)
    {
        $this->config['hosts'] = $hosts;

        return $this;
    }

    /**
     * Set auth params
     *
     * @param $username
     * @param $password
     * @param string $method
     * @return $this
     */
    public function setAuth($username, $password, $method = 'Basic')
    {
        if (!in_array($method, $this->authMethods)) {
            throw new PelasticInvalidArgumentException("Auth type : [$method] is not supported");
        }

        $this->config['auth'] = [
            'username' => $username,
            'password' => $password,
            'method' => $method
        ];

        return $this;
    }

    /**
     * Get array of configs
     *
     * @return array
     */
    public function getArray()
    {
        return $this->config;
    }

    /**
     * Get hosts
     *
     * @return array
     */
    public function getHosts()
    {
        return array_get($this->config, 'hosts', ['http://localhost:9200']);
    }

    /**
     * Does config uses a basic http auth?
     *
     * @return bool
     */
    public function usesHttpAuth()
    {
        return isset($this->config['auth']);
    }

    /**
     * Get auth params
     *
     * @return array
     */
    public function getAuthParams()
    {
        return $this->config['auth'];
    }

    /**
     * Selector instance which is used to select a connection in a pool of connections
     *
     * @param $selector
     * @return $this
     */
    public function setSelector($selector)
    {
        $this->config['selector'] = $selector;

        return $this;
    }

    /**
     * Get used selector
     *
     * @return mixed
     */
    public function getSelector()
    {
        return array_get($this->config, 'selector', $this->getDefaultSelector());
    }

    /**
     * Get default selector instance
     *
     * @return null
     */
    protected function getDefaultSelector()
    {
        return null;
    }

    /**
     * Gets the name the class which is used as the connection pool instance for the pelastic manager
     *
     * @return mixed
     */
    public function getConnectionPoolStrategy()
    {
        return array_get($this->config, 'pool_strategy', $this->getDefaultConnectionPoolStrategy());
    }

    /**
     * Set connection pool strategy
     *
     * @param $strategy
     * @return $this
     */
    public function setConnectionPoolStrategy($strategy)
    {
        $this->config['pool_strategy'] = $strategy;

        return $this;
    }

    /**
     * Get name of the class which is used as the default connection pool strategy
     *
     * @return null
     */
    protected function getDefaultConnectionPoolStrategy()
    {
        return null;
    }
}