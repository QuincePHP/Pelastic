<?php namespace Illuminate\Contracts\Connection;

interface ConnectionPoolInterface {

    /**
     * Get next connection from the selector
     *
     * @return HttpConnectionInterface
     */
    public function getNextConnection();

}