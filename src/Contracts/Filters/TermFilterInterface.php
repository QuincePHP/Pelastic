<?php namespace Quince\Pelastic\Contracts\Filters;

interface TermFilterInterface extends FilterInterface, FieldFilterableInterface {

    /**
     * Field which the term filter should be applied on it
     * a term filter is faster than a term query because it does not care about
     * scoring algos.
     *
     * @param string $field
     * @return $this
     */
    public function fieldForTerm($field);

    /**
     * A proxy for field to exact match
     *
     * @param string $field
     * @return $this
     */
    public function fieldToExactMatch($field);

    /**
     * Value for the field to perform the exact match filter
     *
     * @param string $value
     * @return $this
     */
    public function valueToExactMatch($value);

    /**
     * A proxy for valueToExactMatch
     *
     * @param string $value
     * @return $this
     */
    public function valueForTerm($value);

}