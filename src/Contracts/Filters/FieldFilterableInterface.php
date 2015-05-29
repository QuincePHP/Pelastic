<?php namespace Quince\Pelastic\Contracts\Filters;

interface FieldFilterableInterface {

    /**
     * Sets the field to perform the filter
     *
     * @param string $field
     * @return $this
     */
    public function setField($field);

    /**
     * Sets the value to perform the filter
     *
     * @param string $value
     * @return $this
     */
    public function setValue($value);

    /**
     * Sets both field and value on one place
     *
     * @param string $field
     * @param string $value
     * @return $this
     */
    public function setFieldWithValue($field, $value);

    /**
     * Get value of the filter
     *
     * @return string|null
     */
    public function getValue();

    /**
     * Get field of the filter
     *
     * @return string|null
     */
    public function getField();

}