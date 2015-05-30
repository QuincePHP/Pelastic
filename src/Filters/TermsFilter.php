<?php namespace Quince\Pelastic\Filters;

use Quince\Pelastic\Contracts\Filters\TermsFilterInterface;

class TermsFilter extends Filter implements TermsFilterInterface {

    /**
     * @param null $field
     * @param array $values
     */
    public function __construct($field = null, array $values = null)
    {
        if ($field !== null ) {
           $this->setField($field);
        }

        if ($values !== null && is_array($values)) {
            $this->setField($values);
        }
    }

    /**
     * Set terms to search in
     *
     * @param mixed $in
     * @return $this
     */
    public function setIn($in)
    {
        $in = is_array($in) ? $in : func_get_args();

        $this->setAttribute('values', $in);

        return $this;
    }

    /**
     * A proxy to set in
     *
     * @param mixed $in
     * @return $this
     */
    public function in($in)
    {
        $in = is_array($in) ? $in : func_get_args();

        return $this->setIn($in);
    }

    /**
     * Values to search against
     *
     * @param mixed $values
     * @return $this
     */
    public function terms($values)
    {
        $values = is_array($values) ? $values : func_get_args();

        return $this->setIn($values);
    }

    /**
     * A proxy to terms
     *
     * @param $values
     * @return $this
     */
    public function setValues($values)
    {
        $values = is_array($values) ? $values : func_get_args();

        return $this->setIn($values);
    }

    /**
     * Field to search on
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
     * A proxy to set field
     *
     * @param string $field
     * @return $this
     */
    public function forField($field)
    {
        return $this->setField($field);
    }

    /**
     * A proxy yo set field method
     *
     * @param string $field
     * @return $this
     */
    public function field($field)
    {
        return $this->setField($field);
    }

    /**
     * A proxy to set values method
     *
     * @param array $values
     * @return $this
     */
    public function values($values)
    {
        $values = is_array($values) ? $values : func_get_args();

        return $this->setIn($values);
    }

    /**
     * An array representation of the object
     *
     * @return array
     */
    public function toArray()
    {
        $field = $this->getField(true);

        $values = $this->getValues(true);

        return [
            "terms" => [
                $field => [
                    "value" => $values
                ]
            ]
        ];
    }

    /**
     * Get field that the values are applied to
     *
     * @param bool $hardCheck
     * @return null|string
     */
    public function getField($hardCheck = false)
    {
        return $this->getAttribute('field', (bool) $hardCheck, null);
    }

    /**
     * Get values that are applied to the field
     *
     * @param bool $hardCheck
     * @return array|null
     */
    public function getValues($hardCheck = false)
    {
        return $this->getAttribute('values', (bool) $hardCheck, null);
    }
}