<?php namespace Quince\Pelastic\Queries;

use Quince\Exceptions\PlasticInvalidArgumentException;
use Quince\Pelastic\Contracts\Queries\AccessorMutatorInterface;
use Quince\Pelastic\Contracts\Queries\QueryInterface;
use Quince\Plastic\Exceptions\PlasticLogicException;

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
     * @throws PlasticLogicException
     */
    public function getAttribute($attributeName, $hardCheck = false, $defaultValue = null)
    {
        $attributes = $this->getOptionAttribute();

        if (isset($attributes[$attributeName])) {

            return $attributes[$attributeName];

        }elseif ($hardCheck) {

            throw new PlasticLogicException("You should have set a value for {$attributeName}.");

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
     * @throws PlasticInvalidArgumentException
     */
    public function setBoost($boostValue)
    {
        if (!is_numeric($boostValue)) {

            throw new PlasticInvalidArgumentException("The boost value should be numeric.");

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

        }catch (PlasticLogicException $e) {
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
}
