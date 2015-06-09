<?php namespace Quince\Pelastic\Connection\Selector;

use Illuminate\Contracts\Connection\HttpConnectionInterface;
use Illuminate\Contracts\Connection\Selector\SelectorInterface;

class PerRequestRoundRobinSelector extends Selector implements SelectorInterface {

    /**
     * @var integer
     */
    protected $howMany;

    /**
     * Select from an array of connections
     *
     * @param array $connections
     * @return HttpConnectionInterface
     */
    public function select(array $connections)
    {
        $connection = $connections[$this->howMany % count($connections)];

        $this->howMany++;

        return $connection;
    }
}