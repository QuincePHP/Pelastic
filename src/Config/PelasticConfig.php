<?php namespace Quince\Pelastic\Config;

use Quince\Pelastic\Contracts\Config\PelasticConfigInterface;

class PelasticConfig implements  PelasticConfigInterface {


    /**
     * Bootstrap from array
     *
     * @param array $params
     * @return $this
     */
    public function fromArray(array $params)
    {
        return $this;
    }
}