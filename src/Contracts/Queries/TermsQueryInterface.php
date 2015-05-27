<?php namespace Quince\Pelastic\Contracts\Queries;

use Quince\Pelastic\Queries\TermsQuery;

interface TermsQueryInterface extends QueryInterface {

    /**
     * Sets field to search on
     *
     * @param string $field
     * @return $this
     */
    public function setField($field);

    /**
     * A Proxy on set terms
     *
     * @param array $terms
     * @return TermsQuery
     */
    public function setIn($terms);

    /**
     * Acts like where in with exact values
     *
     * @param array $terms
     * @return $this
     */
    public function setTerms($terms);

    /**
     * A more human friendly proxy on set terms
     *
     * @param array $terms
     * @return $this
     */
    public function in($terms);

}
