<?php namespace Quince\Pelastic\Contracts;

use Quince\Pelastic\Contracts\Utils\ArrayableInterface;
use Quince\Pelastic\Contracts\Utils\JsonableInterface;
use Quince\Pelastic\Document;

interface DocumentInterface extends ArrayableInterface, JsonableInterface {

    /**
     * Create a new instance of document class
     *
     * @param array $attributes
     * @param null $id
     * @param null $metaData
     * @return static
     */
    public function newInstance(array $attributes = null, $id = null, $metaData = null);

    /**
     * Create from attributes
     *
     * @param array $attributes
     * @param null $id
     * @param null $metaData
     * @return $this
     */
    public function create(array $attributes, $id = null, $metaData = null);

    /**
     * An array representation of object
     *
     * @param bool $includeMetaData
     * @return array
     */
    public function toArray($includeMetaData = false);

    /**
     * Unique identifier of the document
     *
     * @return integer|string
     */
    public function getId();

    /**
     * An json representation of object
     *
     * @param int $options
     * @param int $depth
     * @return string
     */
    public function toJson($options = 0, $depth = 512);

    /**
     * Set id attribute
     *
     * @param $id
     * @return $this
     */
    public function setId($id);

    /**
     * Get document meta data
     *
     * @return array
     */
    public function getDocumentMetaData();

    /**
     * Set document meta data
     *
     * @param array $metaData
     * @return $this
     */
    public function setDocumentMetaData(array $metaData = []);

    /**
     * Get meta data attribute
     *
     * @param $attribute
     * @param null $defaultValue
     * @return string
     */
    public function getMetaDataAttribute($attribute, $defaultValue = null);

    /**
     * Set meta data attribute
     *
     * @param $attribute
     * @param $value
     * @return $this
     */
    public function setMetaDataAttribute($attribute, $value);
}