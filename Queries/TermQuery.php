<?php namespace Quince\Pelastic\Queries;
use Quince\Pelastic\ArrayableInterface;

/**
 * Class TermQuery
 * A term query acts like an exact comparison of two string values
 *
 * @package Quince\Pelastic\Queries
 */
class TermQuery extends Query implements TermQueryInterface, ArrayableInterface {

    /**
     * @param $field
     * @param $value
     * @param null $boost
     */
    public function __construct($field, $value, $boost = null)
    {
        $this->setField($field)->setValue($value);

        if ($boost !== null) {

            $this->setBoost($boost);

        }
    }

    /**
     * Set field to exact match a value inside that
     *
     * @param string $field
     * @return TermQueryInterface
     */
    public function setField($field)
    {
        $this->setAttribute('field', $field);
        return $this;
    }

    /**
     * Set value to exact match against the field values
     *
     * @param string $value
     * @return TermQueryInterface
     */
    public function setValue($value)
    {
        $this->setAttribute('value', $value);
        return $this;
    }

    /**
     * An array representation of class
     *
     * @return array
     */
    public function toArray()
    {
        $field = $this->getAttribute('field', true);

        $value = $this->getAttribute('value', true);

        $boost = $this->getAttribute('boost', false, null);

        $query = [
            'term' => [
                 $field => [
                    'value' => $value
                ]
            ]
        ];

        if ($boost !== null) {

            $query['term'][$field]['boost'] = (double) $boost;

        }

        return $query;
    }

    /**
     * Set boost value for the query
     *
     * @param $boostValue
     * @return TermQueryInterface
     */
    public function setBoost($boostValue)
    {
        return $this->setAttribute('boost', $boostValue);
    }
}