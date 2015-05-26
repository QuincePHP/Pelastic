<?php namespace Quince\Pelastic\Queries;

use Quince\Pelastic\Contracts\ArrayableInterface;
use Quince\Pelastic\Contracts\Queries\BoostableInterface;
use Quince\Pelastic\Contracts\Queries\WildcardQueryInterface;

class WildcardQuery extends Query implements WildcardQueryInterface, BoostableInterface, ArrayableInterface {

    /**
     * @param $for
     * @param $wildcardValue
     * @param null $boost
     */
    public function __construct($for, $wildcardValue, $boost = null)
    {
        $this->setField($for);

        $this->setWildCardValue($wildcardValue);

        if ($boost !== null) {

            $this->setBoost($boost);

        }
    }

    /**
     * An array representation of object
     *
     * @return array
     */
    public function toArray()
    {
        $field = $this->getAttribute('field', true);

        $value = $this->getAttribute('value', true);

        $query = [
            'wildcard' => [
                $field => [
                    'value' => $value
                ]
            ]
        ];

        if($boost = $this->getBoost()) {

            $query['wildcard'][$field]['boost'] = $boost;

        }

        return $query;
    }

    /**
     * Set field to apply wildcard query
     *
     * @param $field
     * @return $this
     */
    public function setWildCardField($field)
    {
        return $this->setField($field);
    }

    /**
     * A proxy on setWildCardFieldMethod
     *
     * @param $field
     * @return $this
     */
    public function setField($field)
    {
        return $this->setAttribute('field', $field);
    }

    /**
     * A proxy on set field method
     *
     * @param $field
     * @return WildcardQuery
     */
    public function forField($field)
    {
        return $this->setField($field);
    }

    /**
     * Set wild card value
     *
     * @param $value
     * @return $this
     */
    public function setWildCardValue($value)
    {
        return $this->setAttribute('value', $value);
    }

    /**
     * A proxy on setWildCardValue
     *
     * @param $value
     * @return WildcardQuery
     */
    public function like($value)
    {
        return $this->setWildCardValue($value);
    }

    /**
     * Create string for wildcard matching with "?"
     *
     * @param string $first
     * @param string $second
     * @return string
     */
    public function createSingleAny($first = '', $second = '')
    {
        $string = (string) $first . '?' . (string) $second;

        return $string;
    }

    /**
     * Create string for wildcard matching with "*"
     *
     * @param string $first
     * @param string $second
     * @return string
     */
    public function createMultiAny($first = '', $second = '')
    {
        return (string) $first . '*' . (string) $second;
    }

}