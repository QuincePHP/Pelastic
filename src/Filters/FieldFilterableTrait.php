<?php namespace Quince\Pelastic\Filters;

/**
 * Trait FieldFilterableTrait
 *
 * @method setAttribute($field, $value)
 * @method getAttribute($field, $hardCheck = true, $defaultValue = null)
 * @package Quince\Pelastic\Filters
 */
trait FieldFilterableTrait {

    /**
     * Sets the field to perform the filter
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
     * Sets the value to perform the filter
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
     * Sets both field and value on one place
     *
     * @param string $field
     * @param string $value
     * @return $this
     */
    public function setFieldWithValue($field, $value)
    {
        $this->setField($field)->setValue($value);

        return $this;
    }

    /**
     * Get value of the filter
     *
     * @param bool $hardCheck
     * @return null|string
     */
    public function getValue($hardCheck = false)
    {
        return $this->getAttribute('value', (bool) $hardCheck, null);
    }

    /**
     * Get field of the filter
     *
     * @param bool $hardCheck
     * @return null|string
     */
    public function getField($hardCheck = false)
    {
        return $this->getAttribute('field', (bool) $hardCheck, null);
    }
}