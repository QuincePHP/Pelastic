<?php namespace Quince\Pelastic\Contracts;

interface ArrayableInterface {

    /**
     * An array representation of object
     *
     * @return array
     */
    public function toArray();

}