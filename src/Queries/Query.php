<?php namespace Quince\Pelastic\Queries;

use Quince\Pelastic\AccessibleMutatableTrait;
use Quince\Pelastic\Contracts\Queries\QueryInterface;
use Quince\Pelastic\Exceptions\PelasticInvalidArgumentException;

abstract class Query implements QueryInterface {

    use AccessibleMutatableTrait;

    /**
     * Set boost value for the query
     *
     * @param double $boostValue
     * @return $this
     * @throws PelasticInvalidArgumentException
     */
    public function setBoost($boostValue)
    {
        if (!is_numeric($boostValue)) {

            throw new PelasticInvalidArgumentException("The boost value should be numeric.");

        }

        return $this->setAttribute('boost', (double) $boostValue);
    }

    /**
     * Get boost attribute
     *
     * @return double
     */
    public function getBoost()
    {
        return $this->getAttribute('boost', false, null);
    }

    /**
     * Put a query interface instance into array fields
     *
     * @param string         $field
     * @param QueryInterface $query
     * @return array
     */
    protected function putQueryIntoArrayField($field, QueryInterface $query)
    {
        return $this->putIntoArrayField($field, $query);
    }
}
