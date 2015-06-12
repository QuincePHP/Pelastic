<?php namespace Quince\Pelastic\Utils;

use Quince\Pelastic\Exceptions\PelasticInvalidArgumentException;
use Quince\Pelastic\Exceptions\PelasticLogicException;

/**
 * Trait AccessibleMutatableTrait
 *
 * @property $optionAttribute
 * @package Quince\Pelastic\Utils
 */
trait AccessibleMutatableTrait {

    /**
     * Attribute container
     *
     * @var array
     */
    protected $optionAttribute = [];

    /**
     * Gets the attribute from options array
     *
     * @param string $attributeName
     * @param bool   $hardCheck
     * @param null   $defaultValue
     * @return mixed
     * @throws PelasticLogicException
     */
    public function getAttribute($attributeName, $hardCheck = false, $defaultValue = null)
    {
        $attributes = $this->getOptionAttribute();

        if (isset($attributes[$attributeName])) {

            return $attributes[$attributeName];

        } elseif ($hardCheck) {

            throw new PelasticLogicException("You should have set a value for {$attributeName}.");

        }

        return $defaultValue;
    }

    /**
     * Set attribute on options array
     *
     * @param string $attributeName
     * @param mixed  $value
     * @return $this
     */
    public function setAttribute($attributeName, $value)
    {
        $this->optionAttribute[$attributeName] = $value;

        return $this;
    }

    /**
     * Whether a offset exists
     *
     * @param mixed $offset
     * @return boolean
     */
    public function offsetExists($offset)
    {
        return isset($this->getOptionAttribute()[$offset]);
    }

    /**
     * Offset to retrieve
     *
     * @param mixed $offset
     * @return mixed
     */
    public function offsetGet($offset)
    {
        return $this->getAttribute($offset, false, null);
    }

    /**
     * Offset to set
     *
     * @param mixed $offset
     * @param mixed $value
     * @return void
     */
    public function offsetSet($offset, $value)
    {
        $this->setAttribute($offset, $value);
    }

    /**
     * Offset to unset
     *
     * @param mixed $offset
     * @return void
     */
    public function offsetUnset($offset)
    {
        unset($this->optionAttribute[$offset]);
    }

    /**
     * Getting option attribute
     *
     * @return array
     */
    protected function getOptionAttribute()
    {
        return $this->optionAttribute;
    }

    /**
     * Put an item into an array field
     * if the array does not exists it will be created
     * and the new value is pushed to it, other ways it will be added
     * to the old one
     *
     * @param string $field
     * @param mixed $what
     * @param null $key
     * @return array
     */
    protected function putIntoArrayField($field, $what, $key = null)
    {
        $collection = $this->getAttribute($field, false, []);

        if (!is_array($collection)) {
            throw new PelasticInvalidArgumentException("You can not treat a non-array as array");
        }

        if ($key !== null) {
            $collection[$key] = $what;
        }else {
            $collection = array_push($collection, $what);
        }

        $this->setAttribute($field, $collection);

        return $collection;
    }

    /**
     * Put into associative array
     *
     * @param $field
     * @param $key
     * @param $value
     * @return array
     */
    protected function putIntoAssociativeArrayField($field, $key, $value)
    {
        return $this->putIntoArrayField($field, $value, $key);
    }

    /**
     * Make option attribute container empty
     *
     * @return $this
     */
    protected function emptyOptionAttribute()
    {
        $this->optionAttribute = [];

        return $this;
    }
}