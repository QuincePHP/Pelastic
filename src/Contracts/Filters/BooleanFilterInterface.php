<?php namespace Quince\Pelastic\Contracts\Filters;

interface BooleanFilterInterface extends FilterInterface {

    /**
     * The filter should match the given query in a boolean or way
     *
     * @param FilterInterface $filter
     * @return $this
     */
    public function should(FilterInterface $filter);

    /**
     * The result must have the given criteria
     *
     * @param FilterInterface $filter
     * @return $this
     */
    public function must(FilterInterface $filter);

    /**
     * A collection of shoulds
     *
     * @param $filters
     * @return $this
     */
    public function shoulds($filters);

    /**
     * A collection of musts
     *
     * @param $filters
     * @return $this
     */
    public function musts($filters);

    /**
     * Collection of must nots
     *
     * @param $filters
     * @return $this
     */
    public function mustNots($filters);

    /**
     * The negative condition of must filter
     *
     * @param FilterInterface $filter
     * @return $this
     */
    public function mustNot(FilterInterface $filter);

    /**
     * A proxy to "should"
     *
     * @param FilterInterface $filter
     * @return $this
     */
    public function addOr(FilterInterface $filter);

    /**
     * A proxy to "must"
     *
     * @param FilterInterface $filter
     * @return $this
     */
    public function addAnd(FilterInterface $filter);

    /**
     * Bulk shoulds
     *
     * @param $filters
     * @return $this
     */
    public function ors($filters);

    /**
     * Bulk musts
     *
     * @param $filters
     * @return $this
     */
    public function ands($filters);

    /**
     * A human readable proxy to should
     *
     * @param FilterInterface $filter
     * @return $this
     */
    public function iLike(FilterInterface $filter);

    /**
     * A human readable proxy to must
     *
     * @param FilterInterface $filter
     * @return $this
     */
    public function iDontLike(FilterInterface $filter);

    /**
     * A human readable proxy to must
     *
     * @param FilterInterface $filter
     * @return $this
     */
    public function iReallyNeed(FilterInterface $filter);

    /**
     * See document on elasticsearch
     *
     * @return $this
     */
    public function enableCoord();

    /**
     * See document on elasticsearch
     *
     * @return $this
     */
    public function disableCoord();

    /**
     * Get musts array
     *
     * @return array
     */
    public function  getMusts();

    /**
     * Get shoulds array
     *
     * @return array
     */
    public function getShoulds();

    /**
     * Get must nots array
     *
     * @return array
     */
    public function getMustNots();

    /**
     * Remove all shoulds
     *
     * @return $this
     */
    public function removeShoulds();

    /**
     * Remove all musts
     *
     * @return $this
     */
    public function removeMusts();

    /**
     * Remove all must not queries
     *
     * @return $this
     */
    public function removeMustNots();

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