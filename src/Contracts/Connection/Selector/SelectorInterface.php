<?php namespace Illuminate\Contracts\Connection\Selector;

use Illuminate\Contracts\Connection\HttpConnectionInterface;

interface SelectorInterface {

    /**
     * Select from an array of connections
     *
     * @param array $connections
     * @return HttpConnectionInterface
     */
    public function select(array $connections);

}