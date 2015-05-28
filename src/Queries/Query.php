<?php namespace Quince\Pelastic\Queries;

use Quince\Exceptions\PelasticInvalidArgumentException;
use Quince\Pelastic\Contracts\Queries\QueryInterface;
use Quince\Pelastic\Exceptions\PelasticLogicException;

abstract class Query implements QueryInterface {

    /**
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
     * Set boost value for the query
     *
     * @param double $boostValue
     * @return $this
     * @throws PelasticInvalidArgumentException
     */
    public function setBoost($boostValue)
    {
        if (!is_numeric($boostValue)) {

            throw new PelasticInvalidArgumentException("The boost value should be numeric.");

        }

        return $this->setAttribute('boost', (double) $boostValue);
    }

    /**
     * Get boost attribute
     *
     * @return double
     */
    public function getBoost()
    {
        return $this->getAttribute('boost', false, null);
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
     * @param mixed  $what
     * @return array
     */
    protected function putIntoArrayField($field, $what)
    {
        try {

            $collection = (array) $this->getAttribute($field, true);

            $collection = array_push($collection, $what);

            $this->setAttribute($field, $collection);

        } catch (PelasticLogicException $e) {
            // In case array has not been created yet
            $this->setAttribute($field, $collection = [$what]);

        }

        return $collection;
    }

    /**
     * Put a query interface instance into array fields
     *
     * @param string         $field
     * @param QueryInterface $query
     * @return array
     */
    protected function putQueryIntoArrayField($field, QueryInterface $query)
    {
        return $this->putIntoArrayField($field, $query);
    }
}
