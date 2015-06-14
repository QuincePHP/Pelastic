<?php namespace Quince\Pelastic\Contracts\SqlMonkey;

use Elastica\Filter\BoolFilter;
use Elastica\Query\BoolQuery;
use Elastica\Query\Filtered;
use Elastica\Type;
use Quince\Pelastic\Exceptions\PelasticException;
use Quince\Pelastic\SqlMonkey\QueryBuilder;

interface QueryBuilderInterface {

    /**
     * Set boolean filter instance
     *
     * @param BoolFilter $boolFilter
     * @return $this
     */
    public function setBoolFilter(BoolFilter $boolFilter);

    /**
     * Get type
     *
     * @return Type
     */
    public function getType();

    /**
     * Set type instance
     *
     * @param Type $type
     * @return $this
     */
    public function setType(Type $type);

    /**
     * Get boolean filter instance
     *
     * @return BoolFilter $boolFilter
     */
    public function getBoolFilter();

    /**
     * Set boolean query
     *
     * @param BoolQuery $boolQuery
     * @return $this
     */
    public function setBoolQuery(BoolQuery $boolQuery);

    /**
     * Get boolean query instance
     *
     * @return BoolQuery
     */
    public function getBoolQuery();

    /**
     * Get a clone of current object
     *
     * @return QueryBuilder
     */
    public function getCopy();

    /**
     * Apply a flexible where like what laravel applies
     *
     * @param mixed $field
     * @param null $operator
     * @param null $value
     * @param string $boolean
     * @return QueryBuilder
     * @throws PelasticException
     */
    public function where($field, $operator = null, $value = null, $boolean = 'and');

    /**
     * Apply nested from query
     *
     * @param QueryBuilderInterface $qBuilder
     * @param string $bool
     * @return $this
     */
    public function applyNestedFromQuery(QueryBuilderInterface $qBuilder, $bool = 'and');

    /**
     * Get a new query builder instance
     *
     * @return static
     */
    public function newQuery();

    /**
     * Get boolean filter
     *
     * @return BoolFilter
     */
    public function getBooleanFilter();

    /**
     * Get boolean query
     *
     * @return BoolQuery
     */
    public function getBooleanQuery();

    /**
     * Is And ?
     *
     * @param $bool
     * @return bool
     */
    public function isAnd($bool);

    /**
     * Wrap a set of jobs inside a boolean section
     * of current query scope simply means like this
     * "SELECT * FROM some_table WHERE 'here other conditions' AND|OR (closure condition)";
     *
     * @param \Closure $what
     * @param string $bool
     * @return QueryBuilder
     * @throws PelasticException
     */
    public function wrap(\Closure $what, $bool = 'and');

}