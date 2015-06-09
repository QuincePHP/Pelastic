<?php namespace Quince\Pelastic\Connection\Pool;

use Illuminate\Contracts\Connection\ConnectionPoolInterface;
use Illuminate\Contracts\Connection\HttpConnectionInterface;

class FirstPingConnectionPool implements ConnectionPoolInterface {

    /**
     * Get next connection from the selector
     *
     * @return HttpConnectionInterface
     */
    public function getNextConnection()
    {

    }
}