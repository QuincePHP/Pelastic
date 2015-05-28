<?php namespace Quince\Pelastic\Contracts\Queries;

interface FieldQueryableInterface {

    /**
     * Set field to exact match a value inside that
     *
     * @param string $field
     * @return $this
     */
    public function setField($field);

    /**
     * Set value to exact match against the field values
     *
     * @param string $value
     * @return $this
     */
    public function setValue($value);

    /**
     * A proxy on set value
     *
     * @param $query
     * @return $this
     */
    public function setQuery($query);

}