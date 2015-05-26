<?php namespace Quince\Pelastic\Contracts\Queries;

interface TermQueryInterface {

    /**
     * Set field to exact match a value inside that
     *
     * @param mixed $field
     * @return TermQueryInterface
     */
    public function setField($field);

    /**
     * Set value to exact match against the field values
     *
     * @param mixed $value
     * @return TermQueryInterface
     */
    public function setValue($value);

    /**
     * Set boost value for the query
     *
     * @param mixed $boostValue
     * @return TermQueryInterface
     */
    public function setBoost($boostValue);
}
