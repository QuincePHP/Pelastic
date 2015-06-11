<?php namespace Quince\Pelastic;

use Quince\Pelastic\Contracts\DocumentInterface;
use Quince\Pelastic\Utils\AccessibleMutatableTrait;

class Document implements DocumentInterface, \ArrayAccess {

    use AccessibleMutatableTrait {
        offsetSet as traitOffsetSet;
    }

    /**
     * @var string
     */
    protected $id;

    /**
     * @param array $attributes
     * @param null $id
     */
    public function __construct(array $attributes = null, $id = null)
    {
        foreach($attributes as $attribute => $attributeValue) {
            $this[$attribute] = $attributeValue;
        }

        if (null !== $id) {
            $this->setId($id);
        }
    }

    /**
     * An array representation of object
     *
     * @return array
     */
    public function toArray()
    {
        return $this->getOptionAttribute();
    }

    /**
     * Unique identifier of the document
     *
     * @return integer|string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * An json representation of object
     *
     * @return string
     */
    public function toJson()
    {

    }

    /**
     * Set id attribute
     *
     * @param $id
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * Change if setting id
     *
     * @param $offset
     * @param $value
     */
    public function offsetSet($offset, $value)
    {
        if ($offset === 'id') {
           $this->setId($value); return;
        }

        $this->traitOffsetSet($offset, $value);
    }
}