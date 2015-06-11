<?php namespace Quince\Pelastic\Config;

use Quince\Pelastic\AccessibleMutatableTrait;
use Quince\Pelastic\Contracts\Config\PelasticConfigInterface;

class PelasticConfig implements  PelasticConfigInterface {

    use AccessibleMutatableTrait;

    /**
     * Bootstrap from array
     *
     * @param array $params
     * @return $this
     */
    public function setClientConfig(array $params)
    {
        $this->setAttribute('client_config', $params);
        return $this;
    }

    /**
     * Get client config
     *
     * @return array
     */
    public function getClientConfig()
    {
        return $this->getAttribute('client_config', false, []);
    }
}