<?php namespace Quince\Pelastic\Contracts\Config;

interface PelasticConfigInterface {

    /**
     * Bootstrap from array
     *
     * @param array $params
     * @return $this
     */
    public function fromArray(array $params);

}