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
}