<?php namespace Quince\Pelastic\Contracts\Connection;

interface HttpConnectionInterface {

    /**
     * Perform an http request
     *
     * @param $method
     * @param $uri
     * @param array $params
     * @param array $body
     * @param array $options
     * @return mixed
     */
    public function performRequest($method, $uri, array $params = null, array $body = null, array $options = null);

}