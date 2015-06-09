<?php namespace Quince\Pelastic\SqlMonkey;

use Quince\Pelastic\Contracts\Filters\BooleanFilterInterface;
use Quince\Pelastic\Contracts\Queries\BooleanQueryInterface;
use Quince\Pelastic\Contracts\SqlMonkey\QueryBuilderInterface;
use Quince\Pelastic\Exceptions\PelasticException;
use Quince\Pelastic\Filters\BooleanFilter;
use Quince\Pelastic\PelasticManager;
use Quince\Pelastic\Queries\BooleanQuery;

class QueryBuilder implements QueryBuilderInterface {

    /**
     * The boolean filter container
     * an sql monkey query builder will create a final Filtered query which
     * has two parts the filter section which is used for exact matches as they don't
     * need any score comparison and a query section which contains queries which
     * need scoring like a like query.
     *
     * @var BooleanFilter
     */
    protected $boolFilter;

    /**
     * The boolean query part of the filtered query
     *
     * @var BooleanQuery
     */
    protected $boolQuery;

    /**
     * @var PelasticManager
     */
    protected $manager;

    /**
     * All of the available clause operators.
     *
     * @var array
     */
    protected $operators = [
        '=', '<', '>', '<=', '>=', '<>', '!=',
        'like', 'not like', 'between', 'ilike',
        '&', '|', '^', '<<', '>>',
        'rlike', 'regexp', 'not regexp',
    ];

    /**
     * Constructor of the class
     * @param PelasticManager $manager
     * @param BooleanFilterInterface $boolFilter
     * @param BooleanQueryInterface $boolQuery
     */
    public function __construct(PelasticManager $manager = null, BooleanFilterInterface $boolFilter = null, BooleanQueryInterface $boolQuery = null)
    {
        $this->boolFilter = $boolFilter ?: new BooleanFilter;
        $this->boolQuery = $boolQuery ?: new BooleanQuery;
        $this->manager= $manager ?: PelasticManager::getInstance();
    }

    /**
     * Get a clone of current object
     *
     * @return QueryBuilder
     */
    public function getCopy()
    {
        return clone $this;
    }

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
    public function where($field, $operator = null, $value = null, $boolean = 'and')
    {
        // If the field is an instance of closure
        // we will treat the closure as itself it is a query containing
        // a boolean filter and a boolean query which will be then merged with current
        // query builder instance
        if ($field instanceof \Closure) {

            return $this->wrap($field, $boolean);

        }

        // If the field is and array we guess that the developer wants to
        // create a collection of "equals" with the needed boolean operator
        if (is_array($field)) {

            return $this->wrap(function(QueryBuilderInterface $query) use(&$field, $boolean) {

                foreach ($field as $fieldName => $fieldValue) {

                    $query = $query->where($fieldName, '=', $fieldValue, $boolean);

                }

                return $query;
            });

        }

        // If the user has not given the operator
        // we will treat the second argument as the value
        // and guess that she wants "equals" operator
        if (func_num_args() == 2) {

            list($operator, $value) = ['=', $value];

        }

        return $this;
    }

    /**
     * Apply nested from query
     *
     * @param QueryBuilderInterface $qBuilder
     * @param string $bool
     * @return $this
     */
    public function applyNestedFromQuery(QueryBuilderInterface $qBuilder, $bool = 'and')
    {
        $bq = $this->getBooleanQuery();
        $bf = $this->getBooleanFilter();

        $filter = $qBuilder->getBooleanFilter();
        $query = $qBuilder->getBooleanQuery();

        $method = $this->isAnd($bool) ? 'addAnd' : 'addOr';

        $bf->{$method}($filter);
        $bq->{$method}($query);

        return $this;
    }

    /**
     * Get a new query builder instance
     *
     * @return static
     */
    public function newQuery()
    {
        return new static();
    }

    /**
     * Get boolean filter
     *
     * @return BooleanFilter
     */
    public function getBooleanFilter()
    {
        return $this->boolFilter;
    }

    /**
     * Get boolean query
     *
     * @return BooleanQuery
     */
    public function getBooleanQuery()
    {
        return $this->boolQuery;
    }

    /**
     * Is And ?
     *
     * @param $bool
     * @return bool
     */
    public function isAnd($bool)
    {
        return $bool === 'and';
    }

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
    public function wrap(\Closure $what, $bool = 'and')
    {
        /** @var  $this $query */
        $query = ($result = $what($query = $this->newQuery())) ?: $query;

        if (! $query instanceof $this) {
            $class = __CLASS__;
            throw new PelasticException("Return type of the closure should be an instance of {$class}");
        }

        $this->applyNestedFromQuery($query, $bool);

        return $this;
    }
}