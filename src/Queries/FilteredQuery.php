<?php namespace Quince\Pelastic\Queries;

use Quince\Pelastic\Exceptions\PelasticInvalidArgumentException;
use Quince\Pelastic\Contracts\Filters\FilterInterface;
use Quince\Pelastic\Contracts\Queries\FilteredQueryInterface;
use Quince\Pelastic\Contracts\Queries\QueryInterface;
use Quince\Pelastic\Exceptions\PelasticLogicException;

class FilteredQuery extends Query implements FilteredQueryInterface, FilteredQueryInterface {

    /**
     * Available strategies
     *
     * @var array
     */
    protected $availableStrategies = [
        'leap_frog_query_first',
        'leap_frog_filter_first',
        'leap_frog',
        'query_first',
        'random_access_always'
    ];

    /**
     * @param QueryInterface $query
     * @param FilterInterface $filter
     * @param null $boost
     * @param null $strategy
     */
    public function __construct(
        QueryInterface $query = null,
        FilterInterface $filter = null,
        $boost = null,
        $strategy = null
    ) {
        if ($query === null && $filter === null) {
            $this->throwLogicException();
        }

        if ($query !== null) {
           $this->query($query);
        }

        if ($filter !== null) {
            $this->filter($filter);
        }

        if ($boost !== null) {
           $this->setBoost($boost);
        }

        if ($strategy !== null) {
            $this->setStrategy($strategy);
        }
    }

    /**
     * An array representation of object
     *
     * @return array
     */
    public function toArray()
    {
        $filteredQuery = [];
        $query = $this->getQuery();
        $filter = $this->getFilter();

        if ($query === null && $filter === null) {
            $this->throwLogicException();
        }

        if ($query !== null) {
            $filteredQuery['query'] = $query->toArray();
        }

        if ($filter !== null) {
            $filteredQuery['filter'] = $filter->toArray();
        }

        return ['filtered' => $filteredQuery];
    }

    /**
     * Get query section of the filtered query
     *
     * @return QueryInterface|null
     */
    public function getQuery()
    {
        return $this->getAttribute('query', false, null);
    }

    /**
     * Get filter section of the filtered query
     *
     * @return FilterInterface|null
     */
    public function getFilter()
    {
        return $this->getAttribute('filter', false, null);
    }

    /**
     * Set  query section of the filtered query
     *
     * @param QueryInterface $query
     * @return $this
     */
    public function query(QueryInterface $query)
    {
        $this->setAttribute('query', $query);

        return $this;
    }

    /**
     * Set filter section of the filtered query
     *
     * @param FilterInterface $filter
     * @return $this
     */
    public function filter(FilterInterface $filter)
    {
        $this->setAttribute('filter', $filter);

        return $this;
    }

    /**
     * Throw exception when no filter or query has been set
     *
     * @throws PelasticLogicException
     */
    private function throwLogicException()
    {
        throw new PelasticLogicException("You should at least set a query or a filter");
    }

    /**
     * Set strategy
     *
     * @param $strategy
     * @return $this
     */
    public function setStrategy($strategy)
    {
        if (!$this->strategyIsValid($strategy)) {

            throw new PelasticInvalidArgumentException("Given strategy is not valid");

        }

        $this->setAttribute('strategy', $strategy);

        return $this;
    }

    /**
     * Get strategy
     *
     * @return string
     */
    public function getStrategy()
    {
        return $this->getAttribute('strategy', false, null);
    }

    /**
     * If given strategy is valid
     *
     * @param $strategy
     * @return bool
     */
    public function strategyIsValid($strategy)
    {
        $strategy = (string) $strategy;

        if (in_array($strategy, $this->availableStrategies)) {
           return true;
        }

        $pattern = '/(random_access_[0-9]{1,6}$/';

        return (bool) preg_match($pattern, $strategy);
    }
}
