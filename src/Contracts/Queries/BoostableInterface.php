<?php namespace Quince\Pelastic\Contracts\Queries;

use Quince\Exceptions\PelasticInvalidArgumentException;

interface BoostableInterface {

    /**
     * Set boost value for the query
     *
     * @param double $boostValue
     * @return $this
     * @throws PelasticInvalidArgumentException
     */
    public function setBoost($boostValue);

    /**
     * Get boost attribute
     *
     * @return double
     */
    public function getBoost();

}
