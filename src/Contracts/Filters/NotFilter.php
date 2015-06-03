<?php namespace Quince\Pelastic\Contracts\Filters;

interface NotFilter extends FilterInterface, FilterCacheableInterface {

    /**
     * This filter acts as an all except this filter
     *
     * @param FilterInterface $filter
     * @return $this
     */
    public function iDontWantThisFilter(FilterInterface $filter);

    /**
     * This filter acts as an all except this filter
     *
     * @param FilterInterface $filter
     * @return $this
     */
    public function not(FilterInterface $filter);

    /**
     * A proxy to not
     *
     * @param FilterInterface $filter
     * @return $this
     */
    public function setNot(FilterInterface $filter);

}