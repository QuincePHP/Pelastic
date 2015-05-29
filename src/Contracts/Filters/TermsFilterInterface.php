<?php namespace Quince\Pelastic\Contracts\Filters;

interface TermsFilterInterface extends FilterInterface {

    /**
     * Set terms to search in
     *
     * @param mixed $in
     * @return $this
     */
    public function setIn($in);

    /**
     * A proxy to set in
     *
     * @param mixed $in
     * @return $this
     */
    public function in($in);

    /**
     * Values to search against
     *
     * @param mixed $values
     * @return $this
     */
    public function terms($values);

    /**
     * A proxy to terms
     *
     * @param $values
     * @return $this
     */
    public function setValues($values);

    /**
     * Field to search on
     *
     * @param string $field
     * @return $this
     */
    public function setField($field);

    /**
     * A proxy to set field
     *
     * @param string $field
     * @return $this
     */
    public function forField($field);

    /**
     * A proxy yo set field method
     *
     * @param string $field
     * @return $this
     */
    public function field($field);

    /**
     * A proxy to set values method
     *
     * @param array $values
     * @return $this
     */
    public function values($values);

}