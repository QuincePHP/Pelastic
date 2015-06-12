<?php namespace Quince\Pelastic;

use Quince\Pelastic\Contracts\DocumentInterface;
use Quince\Pelastic\Utils\AccessibleMutatableTrait;

class Document implements DocumentInterface, \ArrayAccess {

    use AccessibleMutatableTrait;

    /**
     * ID field name
     *
     * @var string
     */
    const ID_FIELD = '_id';

    /**
     * Meta data field name
     *
     * @var string
     */
    const META_DATA_FIELD = '_meta_data';

    /**
     * Document meta data
     *
     * @var array
     */
    protected $metaData = [];

    /**
     * @param array $attributes
     * @param null $id
     * @param null $metaData
     */
    public function __construct(array $attributes = null, $id = null, $metaData = null)
    {
        $this->create($attributes, $id, $metaData);
    }

    /**
     * Create a new instance of document class
     *
     * @param array $attributes
     * @param null $id
     * @param null $metaData
     * @return static
     */
    public function newInstance(array $attributes = null, $id = null, $metaData = null)
    {
        return new static($attributes, $id, $metaData);
    }

    /**
     * Create from attributes
     *
     * @param array $attributes
     * @param null $id
     * @param null $metaData
     * @return $this
     */
    public function create(array $attributes, $id = null, $metaData = null)
    {
        $this->emptyOptionAttribute();

        foreach ($attributes as $attribute => $attributeValue) {
            $this[$attribute] = $attributeValue;
        }

        if (null !== $metaData) {
            $this->setDocumentMetaData($metaData);
        }

        if (null !== $id) {
            $this->setId($id);
        }

        return $this;
    }

    /**
     * An array representation of object
     *
     * @param bool $mergeId
     * @param bool $includeMetaData
     * @return array
     */
    public function toArray($mergeId = false, $includeMetaData = false)
    {
        $data = $this->getOptionAttribute();

        if ($includeMetaData) {
            $data[static::META_DATA_FIELD] = $this->getDocumentMetaData();
        }

        if ($mergeId && $this->getId() !== null) {
            $data[static::ID_FIELD] = $this->getId();
        }

        return $data;
    }

    /**
     * Unique identifier of the document
     *
     * @return integer|string
     */
    public function getId()
    {
        return $this->getMetaDataAttribute(static::ID_FIELD);
    }

    /**
     * An json representation of object
     *
     * @param int $options
     * @param int $depth
     * @return string
     */
    public function toJson($options = 0, $depth = 512)
    {
        return json_encode($this->toArray(), $options, $depth);
    }

    /**
     * Set id attribute
     *
     * @param $id
     * @return $this
     */
    public function setId($id)
    {
        $this->setMetaDataAttribute(static::ID_FIELD, $id);

        return $this;
    }

    /**
     * Set magic method
     *
     * @param $attribute
     * @param $value
     * @return void
     */
    public function __set($attribute, $value)
    {
        $this->setAttribute($attribute, $value);
    }

    /**
     * Get magic method
     *
     * @param $attribute
     * @return mixed
     */
    public function __get($attribute)
    {
        return $this->getAttribute($attribute, false, null);
    }

    /**
     * Get document meta data
     *
     * @return array
     */
    public function getDocumentMetaData()
    {
        return $this->metaData;
    }

    /**
     * Set document meta data
     *
     * @param array $metaData
     * @return $this
     */
    public function setDocumentMetaData(array $metaData = [])
    {
        $this->metaData = $metaData;

        return $this;
    }

    /**
     * Get meta data attribute
     *
     * @param $attribute
     * @param null $defaultValue
     * @return string
     */
    public function getMetaDataAttribute($attribute, $defaultValue = null)
    {
        return array_get($this->getDocumentMetaData(), $attribute, $defaultValue);
    }

    /**
     * Set meta data attribute
     *
     * @param $attribute
     * @param $value
     * @return $this
     */
    public function setMetaDataAttribute($attribute, $value)
    {
        $this->metaData[$attribute] = $value;

        return $this;
    }
}