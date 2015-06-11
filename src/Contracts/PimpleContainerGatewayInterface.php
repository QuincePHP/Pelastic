<?php namespace Quince\Pelastic\Contracts;

use Pimple\Container;

interface PimpleContainerGatewayInterface {

    /**
     * Get the pimple container
     *
     * @return Container
     */
    public static function getContainer();

}