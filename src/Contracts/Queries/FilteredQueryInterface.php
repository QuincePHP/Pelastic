<?php
namespace Quince\Pelastic\Contracts\Queries;

use Quince\Pelastic\Contracts\Filters\FilterInterface;

interface FilteredQueryInterface extends QueryInterface{

    /**
     * Get query section of the filtered query
     *
     * @return QueryInterface
     */
    public function getQuery();

    /**
     * Get filter section of the filtered query
     *
     * @return FilterInterface
     */
    public function getFilter();

    /**
     * Set  query section of the filtered query
     *
     * @param QueryInterface $query
     * @return $this
     */
    public function query(QueryInterface $query);

    /**
     * Set filter section of the filtered query
     *
     * @param FilterInterface $filter
     */
    public function filter(FilterInterface $filter);

}