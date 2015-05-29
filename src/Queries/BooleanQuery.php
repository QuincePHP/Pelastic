<?php namespace Quince\Pelastic\Queries;

use Quince\Pelastic\Exceptions\PelasticInvalidArgumentException;
use Quince\Pelastic\Contracts\ArrayableInterface;
use Quince\Pelastic\Contracts\Queries\BooleanQueryInterface;
use Quince\Pelastic\Contracts\Queries\BoostableInterface;
use Quince\Pelastic\Contracts\Queries\QueryInterface;
use Quince\Pelastic\Exceptions\PelasticLogicException;

class BooleanQuery extends Query implements BooleanQueryInterface, ArrayableInterface, BoostableInterface {

    use FieldQueryableTrait;

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

        foreach ($fields as $field) {

            $queries = $this->getAttribute($field, false, []);

            if (!empty($queries)) {

                /** @var QueryInterface $queryItem */
                foreach ($queries as $queryItem) {

                    if (!$queryItem instanceof QueryInterface) {

                        throw new PelasticInvalidArgumentException("All of set queries in a bool query should be an instance of QueryInterface");

                    }

                    $query[$field][] = $queryItem->toArray();

                }

            }

        }

        $this->checkQuery($query);

        $query = ['bool' => $query];

        if ($boost = $this->getBoost() !== null) {
            $query['bool']['boost'] = $boost;
        }

        $minShMatch = $this->getAttribute('minimum_should_match', false, null);

        if ($minShMatch !== null) {
            $query['bool']['minimum_should_match'] = $minShMatch;
        }

        $coord = $this->getAttribute('coord', false, null);

        if ($coord !== null) {
            $query['bool']['disable_coord'] = !(bool) $coord;
        }

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

            throw new PelasticLogicException("You should at least add one query to a boolean query");

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

    /**
     * Add minimum should match functionality
     *
     * @param $value
     * @return $this
     */
    public function withMinimumShouldMatch($value)
    {
        return $this->setMinimumShouldMatch($value);
    }

    /**
     * A proxy to set minimum should match
     *
     * @param $value
     * @return $this
     */
    public function setMinimumShouldMatch($value)
    {
        $this->validateMinimumShouldMatchValue($value);

        $this->setAttribute('minimum_should_match', $value);

        return $this;
    }

    /**
     * Only validates minimum should match value and throws exception on failure
     *
     * @param $value
     */
    protected function validateMinimumShouldMatchValue($value)
    {
        if (is_integer($value)) return;

        if (preg_match('/[0-9]?%/', $value)) return;

        $pattern = '/[0-9]?(<|<=|>|>=|<-|>-)[0-9]?%/';

        // FIXME add the full pattern
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
     * @return array
     */
    public function  getMusts()
    {
        return $this->getAttribute('must', false, []);
    }

    /**
     * Get shoulds array
     *
     * @return array
     */
    public function getShoulds()
    {
        return $this->getAttribute('should', false, []);
    }

    /**
     * Get must nots array
     *
     * @return array|null
     */
    public function getMustNots()
    {
        return $this->getAttribute('must_not', false, []);
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
        unset($this->optionAttribute['must_not']);

        return $this;
    }
}