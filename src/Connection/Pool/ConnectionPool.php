<?php namespace Quince\Pelastic\Connection\Pool;

use Illuminate\Contracts\Connection\HttpConnectionInterface;
use Illuminate\Contracts\Connection\Selector\SelectorInterface;
use Quince\Pelastic\Exceptions\PelasticException;

abstract class ConnectionPool {

    /**
     * @var SelectorInterface;
     */
    protected $selector;

    /**
     * @param SelectorInterface $selector
     */
    public function __construct(SelectorInterface $selector)
    {
        $this->selector = $selector;
    }

    /**
     * Ping timeout
     *
     * @var integer
     */
    const PING_TIMEOUT = 60;

    /**
     * Number of seconds to not check for a dead connection
     *
     * @var integer
     */
    const TTL = 60;

    /**
     * @var array
     */
    protected $connections;


    /**
     * Dead connections
     *
     * @var array
     */
    protected $dead = [];

    /**
     * Set connections
     *
     * @param array $connections
     * @return $this
     */
    public function setConnections(array $connections)
    {
        $this->connections = $connections;

        return $this;
    }

    /**
     * Make a connection dead
     *
     * @param $index
     * @return $this
     */
    public function markDead($index)
    {
        $this->dead[$index] = time() + static::TTL;

        return $this;
    }

    /**
     * Get back to queue if possible
     *
     * @return void
     */
    public function recheck()
    {
        foreach ($this->dead as $index => $expireTime) {

            if ($expireTime <= time()) {
                unset($this->dead[$index]);
            }

        }
    }

    /**
     * Given connection is  dead
     *
     * @param $index
     * @return bool
     */
    protected function isDead($index)
    {
        return isset($this->connections[$index]) && $this->connections[$index] > time();
    }

    /**
     * @param $index
     * @return bool
     */
    public function isAlive($index)
    {
        return !$this->isDead($index);
    }

    /**
     * Get active connections
     *
     * @return array
     */
    public function getActiveConnections()
    {
        $this->recheck();

        $active = array_keys($this->connections) - array_keys($this->dead);

        return array_only($this->connections, $active);
    }

    /**
     * Get next connection from the pool
     *
     * @return HttpConnectionInterface
     * @throws PelasticException
     */
    public function getNextConnection()
    {
        $connections = $this->getActiveConnections();

        if (empty($connection)) {
            throw new PelasticException("Are connections are dead");
        }

        return $this->selector->select($connections);
    }
}