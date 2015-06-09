<?php namespace Illuminate\Contracts\Connection\Pool;

use Illuminate\Contracts\Connection\HttpConnectionInterface;
use Quince\Pelastic\Exceptions\PelasticException;

interface ConnectionPoolInterface {

    /**
     * Get next connection from the pool
     *
     * @return HttpConnectionInterface
     * @throws PelasticException
     */
    public function getNextConnection();

}