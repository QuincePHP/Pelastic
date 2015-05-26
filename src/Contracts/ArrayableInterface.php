<?php namespace Quince\Pelastic\Contracts;

interface ArrayableInterface extends \ArrayAccess {

    /**
     * An array representation of object
     *
     * @return array
     */
    public function toArray();

}