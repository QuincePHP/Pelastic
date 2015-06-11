<?php namespace Quince\Pelastic\Contracts;

use Quince\Pelastic\Contracts\Utils\ArrayableInterface;
use Quince\Pelastic\Contracts\Utils\JsonableInterface;
use Quince\Pelastic\Document;

interface DocumentInterface extends ArrayableInterface, JsonableInterface {

    /**
     * Unique identifier of the document
     *
     * @return integer|string
     */
    public function getId();

    /**
     * Set id attribute
     *
     * @param $id
     * @return $this
     */
    public function setId($id);

    /**
     * Create a new instance of document class
     *
     * @param array $attributes
     * @param null $id
     * @return static
     */
    public function newInstance(array $attributes = null, $id = null);

    /**
     * Create from attributes
     *
     * @param array $attributes
     * @param null $id
     * @return $this
     */
    public function create(array $attributes, $id = null);
}