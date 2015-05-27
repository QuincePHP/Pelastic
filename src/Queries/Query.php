<?php namespace Quince\Pelastic\Queries;

use Quince\Exceptions\PelasticInvalidArgumentException;
use Quince\Pelastic\Contracts\Queries\AccessorMutatorInterface;
use Quince\Pelastic\Contracts\Queries\QueryInterface;
use Quince\Pelastic\Exceptions\PelasticLogicException;

abstract class Query implements AccessorMutatorInterface {

    /**
     * @var array
     */
    protected $optionAttribute = [];

    /**
     * Gets the attribute from options array
     *
     * @param $attributeName
     * @param bool $hardCheck
     * @param null $defaultValue
     * @return null|string
     * @throws PelasticLogicException
     */
    public function getAttribute($attributeName, $hardCheck = false, $defaultValue = null)
    {
        $attributes = $this->getOptionAttribute();

        if (isset($attributes[$attributeName])) {

            return $attributes[$attributeName];

        }elseif ($hardCheck) {

            throw new PelasticLogicException("You should have set a value for {$attributeName}.");

        }

        return $defaultValue;
    }

    /**
     * Set attribute on options array
     *
     * @param $attributeName
     * @param $value
     * @return $this
     */
    public function setAttribute($attributeName, $value)
    {
        $this->optionAttribute[$attributeName] = $value;

        return $this;
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
     * Set boost value for the query
     *
     * @param $boostValue
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
     * @return null|string
     */
    public function getBoost()
    {
        return $this->getAttribute('boost', false, null);
    }

    /**
     * Put an item into an array field
     * if the array does not exists it will be created
     * and the new value is pushed to it, other ways it will be added
     * to the old one
     *
     * @param $field
     * @param $what
     * @return array
     */
    protected function putIntoArrayField($field, $what)
    {
        try {

            $collection = (array) $this->getAttribute($field, true);

            $collection = array_push($collection, $what);

            $this->setAttribute($field, $collection);

        }catch (PelasticLogicException $e) {
            // In case array has not been created yet
            $this->setAttribute($field, $collection = [$what]);

        }

        return $collection;
    }

    /**
     * Put a query interface instance into array fields
     *
     * @param $field
     * @param QueryInterface $query
     * @return array
     */
    protected function putQueryIntoArrayField($field, QueryInterface $query)
    {
        return $this->putIntoArrayField($field, $query);
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Whether a offset exists
     * @link http://php.net/manual/en/arrayaccess.offsetexists.php
     * @param mixed $offset <p>
     * An offset to check for.
     * </p>
     * @return boolean true on success or false on failure.
     * </p>
     * <p>
     * The return value will be casted to boolean if non-boolean was returned.
     */
    public function offsetExists($offset)
    {
        return isset($this->getOptionAttribute()[$offset]);
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Offset to retrieve
     * @link http://php.net/manual/en/arrayaccess.offsetget.php
     * @param mixed $offset <p>
     * The offset to retrieve.
     * </p>
     * @return mixed Can return all value types.
     */
    public function offsetGet($offset)
    {
        return $this->getAttribute($offset, false, null);
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Offset to set
     * @link http://php.net/manual/en/arrayaccess.offsetset.php
     * @param mixed $offset <p>
     * The offset to assign the value to.
     * </p>
     * @param mixed $value <p>
     * The value to set.
     * </p>
     * @return void
     */
    public function offsetSet($offset, $value)
    {
        $this->setAttribute($offset, $value);
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Offset to unset
     * @link http://php.net/manual/en/arrayaccess.offsetunset.php
     * @param mixed $offset <p>
     * The offset to unset.
     * </p>
     * @return void
     */
    public function offsetUnset($offset)
    {
        unset($this->optionAttribute[$offset]);
    }
}
