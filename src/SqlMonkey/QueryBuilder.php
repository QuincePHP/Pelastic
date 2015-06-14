<?php namespace Quince\Pelastic\SqlMonkey;

use Elastica\Filter\BoolFilter;
use Elastica\Filter\Term;
use Elastica\Query\BoolQuery;
use Elastica\Type;
use Quince\Pelastic\Contracts\SqlMonkey\QueryBuilderInterface;
use Quince\Pelastic\Exceptions\PelasticException;
use Quince\Pelastic\Exceptions\PelasticInvalidArgumentException;

class QueryBuilder implements QueryBuilderInterface {

    /**
     * The boolean filter container
     * an sql monkey query builder will create a final Filtered query which
     * has two parts the filter section which is used for exact matches as they don't
     * need any score comparison and a query section which contains queries which
     * need scoring like a like query.
     *
     * @var BoolFilter
     */
    protected $boolFilter;

    /**
     * The boolean query part of the filtered query
     *
     * @var BoolQuery
     */
    protected $boolQuery;

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
     * Sql operator to method mapping
     *
     * @var array
     */
    protected $methodMapping = [
        '=' => 'applyTermFilter',
        'like' => 'applyWildCardQuery'
    ];

    /**
     * @var Type
     */
    protected $type;

    /**
     * @param BoolFilter $boolFilter
     * @param BoolQuery $boolQuery
     * @param Type $type
     */
    public function __construct(BoolFilter $boolFilter = null, BoolQuery $boolQuery = null, Type $type = null)
    {
        $this->setBoolFilter($boolFilter ?: new BoolFilter());
        $this->setBoolQuery($boolQuery ?: new BoolQuery());

        if (null !== $type) {
            $this->setType($type);
        }
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
        if (func_num_args() == 2) list($operator, $value) = ['=', $value];

        $method = $this->mapOperatorToMethod($operator);

        $this->{$method}($field, $value);

        return $this;
    }

    /**
     * Generate a method name from an operator
     *
     * @param $operator
     * @return string
     */
    protected function mapOperatorToMethod($operator)
    {
        if (!array_key_exists($operator, $this->operators)) {

            throw new PelasticInvalidArgumentException(
                "Invalid operator [$operator] set."
            );

        }

        return $this->methodMapping[$operator];
    }

    /**
     * Apply term filter on the monkey
     *
     * @param $field
     * @param $value
     * @return $this
     */
    public function applyTermQuery($field, $value, $negative = false)
    {
        $termFilter = $this->getTermFilter()->setTerm($field, $value);

        if ($value instanceof \Closure) {
            $termFilter = $value($termFilter);
        }

        if ($negative === false) {
            $this->getBoolFilter()->addMust($termFilter);
        }else {
            $this->getBoolFilter()->addMustNot($termFilter);
        }

        return $this;
    }

    /**
     * Get a new term filter instance
     *
     * @return Term
     */
    public function getTermFilter()
    {
        return new Term();
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
     * @return BoolFilter
     */
    public function getBooleanFilter()
    {
        return $this->boolFilter;
    }

    /**
     * Get boolean query
     *
     * @return BoolQuery
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

    /**
     * Set boolean filter instance
     *
     * @param BoolFilter $boolFilter
     * @return $this
     */
    public function setBoolFilter(BoolFilter $boolFilter)
    {
        $this->boolFilter = $boolFilter;

        return $this;
    }

    /**
     * Get type
     *
     * @return Type
     */
    public function getType()
    {

    }

    /**
     * Set type instance
     *
     * @param Type $type
     * @return $this
     */
    public function setType(Type $type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Set boolean query
     *
     * @param BoolQuery $boolQuery
     * @return $this
     */
    public function setBoolQuery(BoolQuery $boolQuery)
    {
        $this->boolQuery = $boolQuery;

        return $this;
    }

    /**
     * Get boolean query instance
     *
     * @return BoolQuery
     */
    public function getBoolQuery()
    {
        return $this->boolQuery;
    }

    /**
     * Get boolean filter instance
     *
     * @return BoolFilter $boolFilter
     */
    public function getBoolFilter()
    {
        return $this->boolFilter;
    }
}