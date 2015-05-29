<?php namespace Quince\Pelastic\SqlMonkey;

use Quince\Exceptions\PelasticInvalidArgumentException;

class QueryFactory extends \Quince\Pelastic\QueryFactory {

    /**
     * Mapper for sql to elasticsearch queries
     *
     * @var array
     */
    private $mapper = [
        '=' => 'term',
        'like' => 'wildcard',
        'in' => 'terms',
        'not in' => 'terms',
        '<>' => 'term',
        '!=' => 'term',
        'is null' => 'exists',
        'is not null' => 'exists',
        'between' => 'range',
    ];

    /**
     * Operators with negative impact
     *
     * @var array
     */
    private $negativeImpact = [
        '<>',
        '!=',
        'not in',
        'is not null'
    ];

    /**
     * Map sql queries to elasticsearch queries
     *
     * @param $sqlQueryCondition
     * @param array $args
     * @return \Quince\Pelastic\Contracts\Queries\QueryInterface
     */
    public function mapSqlToElastic($sqlQueryCondition, array $args = [])
    {
        $mapper = $this->getMapper();

        if (!isset($mapper[$sqlQueryCondition])) {

            throw new PelasticInvalidArgumentException("No sql-to-elasticsearch handler found for [{$sqlQueryCondition}].");

        }

        return $this->create($mapper[$sqlQueryCondition], $args);
    }

    /**
     * Given operator has negative impact
     *
     * @param $operator
     * @return bool
     */
    public function operatorIsNegative($operator)
    {
        return isset($this->getNegativeImpact()[$operator]);
    }

    /**
     * Get sql mapper
     *
     * @return array
     */
    private function getMapper()
    {
        return $this->mapper;
    }

    /**
     * Operators that have negative impact
     *
     * @return array
     */
    private function getNegativeImpact()
    {
        return $this->negativeImpact;
    }
}