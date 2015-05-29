<?php namespace Quince\Pelastic\Contracts\Filters;

use Quince\Pelastic\Contracts\Queries\QueryInterface;

interface QueryFilterInterface extends FilterInterface {

    /**
     * A proxy to query method
     *
     * @param QueryInterface $query
     * @return $this
     */
    public function setQuery(QueryInterface $query);

    /**
     * A proxy to query method
     *
     * @param QueryInterface $query
     * @return $this
     */
    public function applyQuery(QueryInterface $query);

    /**
     * A proxy to query method
     *
     * @param QueryInterface $query
     * @return $this
     */
    public function forQuery(QueryInterface $query);

    /**
     * Query which should be applied as a filter
     *
     * @param QueryInterface $query
     * @return $this
     */
    public function query(QueryInterface $query);

}