<?php namespace Quince\Pelastic\Queries;

use Quince\Exceptions\PlasticInvalidArgumentException;
use Quince\Pelastic\Contracts\ArrayableInterface;
use Quince\Pelastic\Contracts\Queries\BooleanQueryInterface;
use Quince\Pelastic\Contracts\Queries\QueryInterface;
use Quince\Plastic\Exceptions\PlasticLogicException;

class BooleanQuery extends Query implements BooleanQueryInterface, ArrayableInterface {

    /**
     * @param array $shoulds
     * @param array $musts
     * @param array $mustNots
     */
    public function __construct(array $shoulds = [], array $musts = [], array $mustNots = [])
    {
        if (!empty($shoulds)) {

            $this->shoulds($shoulds);

        }

        if (!empty($mustNots)) {

            $this->mustNots($mustNots);

        }

        if (!empty($musts)) {

            $this->musts($musts);

        }
    }

    /**
     * An array representation of object
     *
     * @return array
     */
    public function toArray()
    {
        $query = [];

        $fields = ['should', 'must', 'must_not'];

        foreach($fields as $field) {

            $queries = $this->getAttribute($field, false, []);

            if (!empty($queries)) {

                foreach ($queries as $queryItem) {

                    if(!$queryItem instanceof QueryInterface) {

                        throw new PlasticInvalidArgumentException("All of set queries in a bool query should be an instance of QueryInterface");

                    }

                    $query[$field][] = $queryItem;

                }

            }

        }

        $this->checkQuery($query);

        return $query;
    }

    /**
     * Ensure that query is valid
     *
     * @param array $query
     */
    protected function checkQuery(array &$query)
    {
        if (empty($query)) {

            throw new PlasticLogicException("You should at least add one query to a boolean query");

        }
    }

    /**
     * The query should match the given query in a boolean or way
     *
     * @param QueryInterface $query
     * @return $this
     */
    public function should(QueryInterface $query)
    {
        $this->putQueryIntoArrayField('should', $query);

        return $this;
    }

    /**
     * The result must have the given criteria
     *
     * @param QueryInterface $query
     * @return $this
     */
    public function must(QueryInterface $query)
    {
        $this->putQueryIntoArrayField('must', $query);

        return $this;
    }

    /**
     * A collection of shoulds
     *
     * @param $queries
     * @return $this
     */
    public function shoulds($queries)
    {
        $queries = is_array($queries) ? $queries : func_get_args();

        foreach ($queries as $query) {

            $this->should($query);

        }

        return $this;
    }

    /**
     * A collection of musts
     *
     * @param $queries
     * @return $this
     */
    public function musts($queries)
    {
        $queries = is_array($queries) ? $queries : func_get_args();

        foreach ($queries as $query) {

            $this->must($query);

        }

        return $this;
    }

    /**
     * Collection of must nots
     *
     * @param $queries
     * @return $this
     */
    public function mustNots($queries)
    {
        $queries = is_array($queries) ? $queries : func_get_args();

        foreach ($queries as $query) {

            $this->mustNot($query);

        }

        return $this;
    }

    /**
     * The negative condition of must query
     *
     * @param QueryInterface $query
     * @return $this
     */
    public function mustNot(QueryInterface $query)
    {
        $this->putQueryIntoArrayField('must_not', $query);

        return $this;
    }

    /**
     * A proxy to "should"
     *
     * @param QueryInterface $query
     * @return $this
     */
    public function addOr(QueryInterface $query)
    {
        return $this->should($query);
    }

    /**
     * A proxy to "must"
     *
     * @param QueryInterface $query
     * @return $this
     */
    public function addAnd(QueryInterface $query)
    {
        return $this->must($query);
    }

    /**
     * Bulk shoulds
     *
     * @param $queries
     * @return $this
     */
    public function ors($queries)
    {
        return $this->shoulds($queries);
    }

    /**
     * Bulk musts
     *
     * @param $queries
     * @return $this
     */
    public function ands($queries)
    {
        return $this->musts($queries);
    }

    /**
     * A human readable proxy to should
     *
     * @param QueryInterface $query
     * @return $this
     */
    public function iLike(QueryInterface $query)
    {
        return $this->should($query);
    }

    /**
     * A human readable proxy to must
     *
     * @param QueryInterface $query
     * @return $this
     */
    public function iDontLike(QueryInterface $query)
    {
        return $this->mustNot($query);
    }

    /**
     * A human readable proxy to must
     *
     * @param QueryInterface $query
     * @return $this
     */
    public function iReallyNeed(QueryInterface $query)
    {
        return $this->must($query);
    }
}