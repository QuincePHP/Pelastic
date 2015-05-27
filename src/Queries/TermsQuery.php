<?php namespace Quince\Pelastic\Queries;

use Quince\Pelastic\Contracts\ArrayableInterface;
use Quince\Pelastic\Contracts\Queries\BoostableInterface;
use Quince\Pelastic\Contracts\Queries\TermsQueryInterface;

class TermsQuery extends Query implements TermsQueryInterface, BoostableInterface {

    /**
     * Set field attribute
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
     * A more friendly proxy to set terms method
     *
     * @param array $terms
     * @return $this
     */
    public function setIn($terms)
    {
        $terms = is_array($terms) ? $terms : func_get_args();

        return $this->setTerms($terms);
    }

    /**
     * Sets array of terms into terms attribute of an elasticsearch query
     * acts like "where in" on sql
     *
     * @param array $terms
     * @return $this
     */
    public function setTerms($terms)
    {
        $terms = is_array($terms) ? $terms : func_get_args();

        return $this->setTermsAttribute($terms);
    }

    /**
     * A Proxy on set terms
     *
     * @param array $terms
     * @return $this
     */
    public function in($terms)
    {
        $terms = is_array($terms) ? $terms : func_get_args();

        return $this->setTermsAttribute($terms);
    }

    /**
     * An array representation of object
     *
     * @return array
     */
    public function toArray()
    {
        $value = $this->getAttribute('terms', true);

        $field = $this->getAttribute('field', true);

        $query = [
            'terms' => [
                $field => [
                    'value' => $value
                ]
            ]
        ];

        $query = $this->addBoostToQuery($query);

        return $query;
    }

    /**
     * Add boost to query
     *
     * @param array $query
     * @return array
     */
    protected function addBoostToQuery($query)
    {
        if ($boost = $this->getBoost() !== null) {

            $field = $this->getAttribute('field', true);

            $query['terms'][$field]['boost'] = $boost;

        }

        return $query;
    }

    /**
     * Sets terms on an elasticsearch query
     *
     * @param array $terms
     * @return $this
     */
    protected function setTermsAttribute(array $terms)
    {
        $this->setAttribute('terms', array_values($terms));

        return $this;
    }
}
