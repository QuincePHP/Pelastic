<?php namespace Quince\Pelastic\Contracts\Config;

interface PelasticConfigInterface {

    /**
     * Bootstrap from array
     *
     * @param array $params
     * @return $this
     */
    public function setClientConfig(array $params);

    /**
     * Get client config
     *
     * @return array
     */
    public function getClientConfig();
}