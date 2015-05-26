<?php namespace Quince\Pelastic\Contracts\Queries;

interface WildcardQueryInterface extends QueryInterface {

    /**
     * Set field to apply wildcard query
     *
     * @param $field
     * @return $this
     */
    public function setWildCardField($field);

    /**
     * A proxy on setWildCardFieldMethod
     *
     * @param $field
     * @return $this
     */
    public function setField($field);

    /**
     * A proxy on set field method
     *
     * @param $field
     * @return $this
     */
    public function forField($field);

    /**
     * Set wild card value
     *
     * @param $value
     * @return $this
     */
    public function setWildCardValue($value);

    /**
     * A proxy on setWildCardValue
     *
     * @param $value
     * @return $this
     */
    public function like($value);

    /**
     * Create string for wildcard matching with "?"
     *
     * @param string $first
     * @param string $second
     * @return string
     */
    public function createSingleAny($first = '', $second = '');

    /**
     * Create string for wildcard matching with "*"
     *
     * @param string $first
     * @param string $second
     * @return string
     */
    public function createMultiAny($first = '', $second = '');

}