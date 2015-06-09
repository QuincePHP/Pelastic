<?php namespace Illuminate\Contracts\Config;

interface PelasticConfigInterface {

    /**
     * Create a new config class from array
     *
     * @param array $config
     * @return $this
     */
    public static function buildFromArray(array $config);

    /**
     * Set hosts to be used to init connections
     *
     * @param array $hosts
     * @return $this
     */
    public function setHosts(array $hosts);

    /**
     * Set auth params
     *
     * @param $username
     * @param $password
     * @param string $method
     * @return $this
     */
    public function setAuth($username, $password, $method = 'Basic');

    /**
     * Get array of configs
     *
     * @return array
     */
    public function getArray();

    /**
     * Get hosts
     *
     * @return array
     */
    public function getHosts();

    /**
     * Does config uses a basic http auth?
     *
     * @return bool
     */
    public function usesHttpAuth();

    /**
     * Get auth params
     *
     * @return array
     */
    public function getAuthParams();

    /**
     * Selector instance which is used to select a connection in a pool of connections
     *
     * @param $selector
     * @return $this
     */
    public function setSelector($selector);

    /**
     * Get used selector
     *
     * @return mixed
     */
    public function getSelector();

    /**
     * Gets the name the class which is used as the connection pool instance for the pelastic manager
     *
     * @return mixed
     */
    public function getConnectionPoolStrategy();
}