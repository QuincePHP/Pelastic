<?php namespace Quince\Pelastic\Contracts\Filters;

interface FilterCacheableInterface {

    /**
     * Set cache
     *
     * @param (bool) $bool
     * @return $this
     */
    public function setCache($bool);

    /**
     * Cache status
     *
     * @return bool
     */
    public function getCacheStatus();

    /**
     * Enable cache on query
     *
     * @return $this
     */
    public function enableCache();

    /**
     * Disable cache
     *
     * @return $this
     */
    public function disableCache();

}