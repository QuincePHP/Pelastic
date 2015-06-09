<?php namespace Quince\Pelastic\Filters;

/**
 * Trait FilterCacheableTrait
 *
 * @method setAttribute($attr, $value)
 * @method getAttribute($attr, $hardCheck = true, $defaultVal = null)
 * @package Quince\Pelastic\Filters
 */
trait FilterCacheableTrait {

    /**
     * Set cache
     *
     * @param (bool) $bool
     * @return $this
     */
    public function setCache($bool)
    {
        $this->setAttribute('cache', (bool) $bool);

        return $this;
    }

    /**
     * Cache status
     *
     * @return bool
     */
    public function getCacheStatus()
    {
        return $this->getAttribute('cache', false, null);
    }

    /**
     * Enable cache on query
     *
     * @return $this
     */
    public function enableCache()
    {
        return $this->setCache(true);
    }

    /**
     * Disable cache
     *
     * @return $this
     */
    public function disableCache()
    {
        return $this->setCache(false);
    }

}