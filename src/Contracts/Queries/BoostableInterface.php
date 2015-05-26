<?php namespace Quince\Pelastic\Contracts\Queries;

interface BoostableInterface {

    /**
     * Sets boost value on query
     *
     * @param double $boostValue
     * @return $this
     */
    public function setBoost($boostValue);

}