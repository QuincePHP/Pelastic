<?php namespace Quince\Pelastic\Contracts\SqlMonkey;

use Quince\Pelastic\Exceptions\PelasticException;
use Quince\Pelastic\Filters\BooleanFilter;
use Quince\Pelastic\Queries\BooleanQuery;
use Quince\Pelastic\SqlMonkey\QueryBuilder;

interface QueryBuilderInterface {

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
     * @return BooleanFilter
     */
    public function getBooleanFilter();

    /**
     * Get boolean query
     *
     * @return BooleanQuery
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