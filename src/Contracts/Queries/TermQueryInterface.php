<?php namespace Quince\Pelastic\Contracts\Queries;

interface TermQueryInterface extends QueryInterface {

    /**
     * Set field to exact match a value inside that
     *
     * @param string $field
     * @return TermQueryInterface
     */
    public function setField($field);

    /**
     * Set value to exact match against the field values
     *
     * @param string $value
     * @return TermQueryInterface
     */
    public function setValue($value);

}
