<?php namespace Quince\Pelastic\Connection\Selector;

use Quince\Pelastic\Contracts\Connection\HttpConnectionInterface;
use Quince\Pelastic\Contracts\Connection\Selector\SelectorInterface;

class PerScriptRoundRobinSelector extends Selector implements SelectorInterface {

    /**
     * @var HttpConnectionInterface
     */
    protected $selected;

    /**
     * Select from an array of connections
     *
     * @param array $connections
     * @return HttpConnectionInterface
     */
    public function select(array $connections)
    {
        if (null === $this->selected) {
            $this->selected = array_rand($connections);
        }

        return $this->selected;
    }
}