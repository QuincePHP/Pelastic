<?php namespace Quince\Pelastic\Queries;

/**
 * Class FieldQueryableTrait
 *
 * @method setAttribute($attribute, $attributeValue)
 * @package Quince\Pelastic\Queries
 */
trait FieldQueryableTrait {

    /**
     * Set field to perform query on
     *
     * @param string $field
     * @return $this
     */
    public function setField($field)
    {
        $this->setAttribute('field', $field);

        return $this;
    }

    /**
     * Set value of the query
     *
     * @param string $value
     * @return $this
     */
    public function setValue($value)
    {
        $this->setAttribute('value', $value);

        return $this;
    }

    /**
     * A proxy on set value
     *
     * @param $query
     * @return $this
     */
    public function setQuery($query)
    {
        return $this->setValue($query);
    }

}