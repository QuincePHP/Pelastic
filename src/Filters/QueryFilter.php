<?php namespace Quince\Pelastic\Filters;

use Quince\Pelastic\Contracts\Filters\QueryFilterInterface;
use Quince\Pelastic\Contracts\Queries\QueryInterface;

class QueryFilter extends Filter implements QueryFilterInterface {

    /**
     * An array representation of the object
     *
     * @return array
     */
    public function toArray()
    {
        return [
            "query" => $this->getQuery()->toArray()
        ];
    }

    /**
     * A proxy to query method
     *
     * @param QueryInterface $query
     * @return $this
     */
    public function setQuery(QueryInterface $query)
    {
        $this->setAttribute('query', $query);

        return $this;
    }

    /**
     * A proxy to query method
     *
     * @param QueryInterface $query
     * @return $this
     */
    public function applyQuery(QueryInterface $query)
    {
        return $this->setQuery($query);
    }

    /**
     * A proxy to query method
     *
     * @param QueryInterface $query
     * @return $this
     */
    public function forQuery(QueryInterface $query)
    {
        return $this->setQuery($query);
    }

    /**
     * Query which should be applied as a filter
     *
     * @param QueryInterface $query
     * @return $this
     */
    public function query(QueryInterface $query)
    {
        return $this->setQuery($query);
    }

    /**
     * Get query that should be applied as a filter
     *
     * @return QueryInterface
     */
    public function getQuery()
    {
        return $this->getAttribute('query', true);
    }
}