<?php namespace Quince\Pelastic\Contracts\Utils;

interface JsonableInterface {

    /**
     * An json representation of object
     *
     * @return string
     */
    public function toJson();

}
