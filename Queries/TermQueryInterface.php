<?php namespace Quince\Pelastic\Queries;

interface TermQueryInterface {

    /**
     * Set field to exact match a value inside that
     *
     * @param $field
     * @return TermQueryInterface
     */
    public function setField($field);

    /**
     * Set value to exact match against the field values
     *
     * @param $value
     * @return TermQueryInterface
     */
    public function setValue($value);

    /**
     * Set boost value for the query
     *
     * @param $boostValue
     * @return TermQueryInterface
     */
    public function setBoost($boostValue);
}