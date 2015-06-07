<?php namespace Quince\Pelastic\Contracts;

interface DocumentInterface extends ArrayableInterface, JsonableInterface{

    /**
     * Unique identifier of the document
     *
     * @return integer|string
     */
    public function getId();

}