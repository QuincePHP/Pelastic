<?php namespace Quince\Pelastic\Contracts;

use Quince\Pelastic\Contracts\Utils\ArrayableInterface;
use Quince\Pelastic\Contracts\Utils\JsonableInterface;

interface DocumentInterface extends ArrayableInterface, JsonableInterface {

    /**
     * Unique identifier of the document
     *
     * @return integer|string
     */
    public function getId();

}