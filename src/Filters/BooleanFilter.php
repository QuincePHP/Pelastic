<?php namespace Quince\Pelastic\Filters;

use Quince\Pelastic\Contracts\Filters\BooleanFilterInterface;
use Quince\Pelastic\Contracts\Filters\FilterInterface;
use Quince\Pelastic\Exceptions\PelasticInvalidArgumentException;
use Quince\Pelastic\Exceptions\PelasticLogicException;

class BooleanFilter extends Filter implements BooleanFilterInterface {

    /**
     * @param array $musts
     * @param array $shoulds
     * @param array $mustNots
     * @param null $cache
     */
    public function __construct(array $musts = null, array $shoulds = null, array $mustNots = null, $cache = null)
    {
        if ($musts !== null) {
            $this->musts($musts);
        }

        if ($shoulds !== null) {
            $this->shoulds($shoulds);
        }

        if ($mustNots !== null) {
            $this->mustNots($mustNots);
        }

        if ($cache !== null) {
            $this->setCache($cache);
        }
    }

    /**
     * An array representation of object
     *
     * @return array
     */
    public function toArray()
    {
        $filter = [];

        $fields = ['should', 'must', 'must_not'];

        foreach ($fields as $field) {

            $filters = $this->getAttribute($field, false, []);

            if (!empty($filters)) {

                /** @var FilterInterface $filterItem */
                foreach ($filters as $filterItem) {

                    if (!$filterItem instanceof FilterInterface) {

                        throw new PelasticInvalidArgumentException("All of set filter in a bool filter should be an instance of FilterInterface");

                    }

                    $filter[$field][] = $filterItem->toArray();

                }

            }

        }

        $this->checkFilter($filter);

        $query = ['bool' => $filter];

        $coord = $this->getAttribute('coord', false, null);

        if ($coord !== null) {
            $query['bool']['disable_coord'] = !(bool) $coord;
        }

        return $query;
    }

    /**
     * Check that filter is correct and queryable
     *
     * @param $filter
     */
    protected function checkFilter($filter)
    {
        if (empty($filter)) {

            throw new PelasticLogicException("You should at least set one filter inside a boolean filter container.");

        }
    }

    /**
     * The filter should match the given query in a boolean or way
     *
     * @param FilterInterface $filter
     * @return $this
     */
    public function should(FilterInterface $filter)
    {
        $this->putFilterIntoArrayField('should', $filter);

        return $this;
    }

    /**
     * The result must have the given criteria
     *
     * @param FilterInterface $filter
     * @return $this
     */
    public function must(FilterInterface $filter)
    {
        $this->putFilterIntoArrayField('must', $filter);

        return $this;
    }

    /**
     * A collection of shoulds
     *
     * @param $filters
     * @return $this
     */
    public function shoulds($filters)
    {
        $filters = is_array($filters) ? $filters : func_get_args();

        /** @var FilterInterface $filter */
        foreach ($filters as $filter) {
            $this->should($filter);
        }

        return $this;
    }

    /**
     * A collection of musts
     *
     * @param $filters
     * @return $this
     */
    public function musts($filters)
    {
        $filters = is_array($filters) ? $filters : func_get_args();

        /** @var FilterInterface $filter */
        foreach ($filters as $filter) {
            $this->must($filter);
        }

        return $this;
    }

    /**
     * Collection of must nots
     *
     * @param $filters
     * @return $this
     */
    public function mustNots($filters)
    {
        $filters = is_array($filters) ? $filters : func_get_args();

        /** @var FilterInterface $filter */
        foreach ($filters as $filter) {
            $this->mustNot($filter);
        }

        return $this;
    }

    /**
     * The negative condition of must filter
     *
     * @param FilterInterface $filter
     * @return $this
     */
    public function mustNot(FilterInterface $filter)
    {
        $this->putFilterIntoArrayField('must_not', $filter);

        return $this;
    }

    /**
     * A proxy to "should"
     *
     * @param FilterInterface $filter
     * @return $this
     */
    public function addOr(FilterInterface $filter)
    {
        return $this->should($filter);
    }

    /**
     * A proxy to "must"
     *
     * @param FilterInterface $filter
     * @return $this
     */
    public function addAnd(FilterInterface $filter)
    {
        return $this->must($filter);
    }

    /**
     * Bulk shoulds
     *
     * @param $filters
     * @return $this
     */
    public function ors($filters)
    {
        $filters = is_array($filters) ? $filters : func_get_args();

        return $this->shoulds($filters);
    }

    /**
     * Bulk musts
     *
     * @param $filters
     * @return $this
     */
    public function ands($filters)
    {
        $filters = is_array($filters) ? $filters : func_get_args();

        return $this->musts($filters);
    }

    /**
     * A human readable proxy to should
     *
     * @param FilterInterface $filter
     * @return $this
     */
    public function iLike(FilterInterface $filter)
    {
        return $this->should($filter);
    }

    /**
     * A human readable proxy to must
     *
     * @param FilterInterface $filter
     * @return $this
     */
    public function iDontLike(FilterInterface $filter)
    {
        return $this->mustNot($filter);
    }

    /**
     * A human readable proxy to must
     *
     * @param FilterInterface $filter
     * @return $this
     */
    public function iReallyNeed(FilterInterface $filter)
    {
        return $this->must($filter);
    }

    /**
     * See document on elasticsearch
     *
     * @return $this
     */
    public function enableCoord()
    {
        $this->setAttribute('coord', true);

        return $this;
    }

    /**
     * See document on elasticsearch
     *
     * @return $this
     */
    public function disableCoord()
    {
        $this->setAttribute('coord', false);

        return $this;
    }

    /**
     * Get musts array
     *
     * @return array|null
     */
    public function  getMusts()
    {
        return $this->getAttribute('must', false, null);
    }

    /**
     * Get shoulds array
     *
     * @return array|null
     */
    public function getShoulds()
    {
        return $this->getAttribute('should', false, null);
    }

    /**
     * Get must nots array
     *
     * @return array|null
     */
    public function getMustNots()
    {
        return $this->getAttribute('must_not', false, null);
    }

    /**
     * Remove all shoulds
     *
     * @return $this
     */
    public function removeShoulds()
    {
        unset($this->optionAttribute['should']);

        return $this;
    }

    /**
     * Remove all musts
     *
     * @return $this
     */
    public function removeMusts()
    {
        unset($this->optionAttribute['must']);

        return $this;
    }

    /**
     * Remove all must not queries
     *
     * @return $this
     */
    public function removeMustNots()
    {
        unset($this->optionAttribute['must']);

        return $this;
    }

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
        return (bool) $this->getAttribute('cache', false, null);
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