<?php namespace Quince\Pelastic\Contracts\Queries;

interface BooleanQueryInterface extends QueryInterface {

    /**
     * The query should match the given query in a boolean or way
     *
     * @param QueryInterface $query
     * @return $this
     */
    public function should(QueryInterface $query);

    /**
     * The result must have the given criteria
     *
     * @param QueryInterface $query
     * @return $this
     */
    public function must(QueryInterface $query);

    /**
     * A collection of shoulds
     *
     * @param $queries
     * @return $this
     */
    public function shoulds($queries);

    /**
     * A collection of musts
     *
     * @param $queries
     * @return $this
     */
    public function musts($queries);

    /**
     * Collection of must nots
     *
     * @param $queries
     * @return $this
     */
    public function mustNots($queries);

    /**
     * The negative condition of must query
     *
     * @param QueryInterface $query
     * @return $this
     */
    public function mustNot(QueryInterface $query);

    /**
     * A proxy to "should"
     *
     * @param QueryInterface $query
     * @return $this
     */
    public function addOr(QueryInterface $query);

    /**
     * A proxy to "must"
     *
     * @param QueryInterface $query
     * @return $this
     */
    public function addAnd(QueryInterface $query);

    /**
     * Bulk shoulds
     *
     * @param $queries
     * @return $this
     */
    public function ors($queries);

    /**
     * Bulk musts
     *
     * @param $queries
     * @return $this
     */
    public function ands($queries);

    /**
     * A human readable proxy to should
     *
     * @param QueryInterface $query
     * @return $this
     */
    public function iLike(QueryInterface $query);

    /**
     * A human readable proxy to must
     *
     * @param QueryInterface $query
     * @return $this
     */
    public function iDontLike(QueryInterface $query);

    /**
     * A human readable proxy to must
     *
     * @param QueryInterface $query
     * @return $this
     */
    public function iReallyNeed(QueryInterface $query);

    /**
     * Add minimum should match functionality
     *
     * @param $value
     * @return $this
     */
    public function withMinimumShouldMatch($value);

    /**
     * A proxy to set minimum should match
     *
     * @param $value
     * @return $this
     */
    public function setMinimumShouldMatch($value);

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
}