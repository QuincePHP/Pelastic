<?php namespace Quince\Pelastic\Contracts\Api;

interface RequestInterface {

    /**
     * Execute a request
     *
     * @return array
     */
    public function execute();

}