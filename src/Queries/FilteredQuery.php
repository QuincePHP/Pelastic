<?php namespace Quince\Pelastic\Queries;

use Quince\Pelastic\Contracts\Filters\FilterInterface;
use Quince\Pelastic\Contracts\Queries\FilteredQueryInterface;
use Quince\Pelastic\Contracts\Queries\QueryInterface;
use Quince\Pelastic\Exceptions\PelasticLogicException;

class FilteredQuery extends Query implements FilteredQueryInterface, FilteredQueryInterface {

    /**
     * @param QueryInterface $query
     * @param FilterInterface $filter
     * @param null $boost
     */
    public function __construct(QueryInterface $query = null, FilterInterface $filter = null, $boost = null)
    {
        if ($query === null && $filter === null) {
            $this->throwLogicException();
        }

        if ($query !== null) {
           $this->query($query);
        }

        if ($filter !== null) {
            $this->filter($filter);
        }

        if ($boost !== null) {
           $this->setBoost($boost);
        }
    }

    /**
     * An array representation of object
     *
     * @return array
     */
    public function toArray()
    {
        $filteredQuery = [];
        $query = $this->getQuery();
        $filter = $this->getFilter();

        if ($query === null && $filter === null) {
            $this->throwLogicException();
        }

        if ($query !== null) {
            $filteredQuery['query'] = $query->toArray();
        }

        if ($filter !== null) {
            $filteredQuery['filter'] = $filter->toArray();
        }

        return ['filtered' => $filteredQuery];
    }

    /**
     * Get query section of the filtered query
     *
     * @return QueryInterface|null
     */
    public function getQuery()
    {
        return $this->getAttribute('query', false, null);
    }

    /**
     * Get filter section of the filtered query
     *
     * @return FilterInterface|null
     */
    public function getFilter()
    {
        return $this->getAttribute('filter', false, null);
    }

    /**
     * Set  query section of the filtered query
     *
     * @param QueryInterface $query
     * @return $this
     */
    public function query(QueryInterface $query)
    {
        $this->setAttribute('query', $query);

        return $this;
    }

    /**
     * Set filter section of the filtered query
     *
     * @param FilterInterface $filter
     */
    public function filter(FilterInterface $filter)
    {
        $this->setAttribute('filter', $filter);
    }

    /**
     * Throw exception when no filter or query has been set
     *
     * @throws PelasticLogicException
     */
    private function throwLogicException()
    {
        throw new PelasticLogicException("You should at least set a query or a filter");
    }
}