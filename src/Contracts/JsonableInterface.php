<?php namespace Quince\Pelastic\Contracts;

interface JsonableInterface {

    /**
     * An json representation of object
     *
     * @return json
     */
    public function toJson();

}
