<?php namespace Quince\Pelastic\Queries;

use Quince\Pelastic\Contracts\Queries\BoostableInterface;
use Quince\Pelastic\Contracts\Queries\WildcardQueryInterface;

class WildcardQuery extends Query implements WildcardQueryInterface, BoostableInterface {

    use FieldQueryableTrait;

    /**
     * @param mixed       $for
     * @param string      $wildcardValue
     * @param double|null $boost
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

        if ($boost = $this->getBoost()) {

            $query['wildcard'][$field]['boost'] = $boost;

        }

        return $query;
    }

    /**
     * Set field to apply wildcard query
     *
     * @param string $field
     * @return $this
     */
    public function setWildCardField($field)
    {
        return $this->setField($field);
    }

    /**
     * A proxy on setWildCardFieldMethod
     *
     * @param mixed $field
     * @return $this
     */
    public function setField($field)
    {
        return $this->setAttribute('field', $field);
    }

    /**
     * A proxy on set field method
     *
     * @param mixed $field
     * @return $this
     */
    public function forField($field)
    {
        return $this->setField($field);
    }

    /**
     * Set wild card value
     *
     * @param string $value
     * @return $this
     */
    public function setWildCardValue($value)
    {
        return $this->setAttribute('value', $value);
    }

    /**
     * A proxy on setWildCardValue
     *
     * @param string $value
     * @return $this
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

    /**
     * Match only with single character in both sides of an string
     *
     * @param string $string
     * @return string
     */
    public function wrapSingleAroundString($string)
    {
        return '?' . (string) $string . '?';
    }

    /**
     * Only match single for end of the string
     *
     * @param string $string
     * @return string
     */
    public function endSingleMatchForString($string)
    {
        return ($string) . '?';
    }

    /**
     * Single char match from the beginning of the string
     *
     * @param string $string
     * @return string
     */
    public function beginSingleMatchForString($string)
    {
        return '?' . (string) $string;
    }

    /**
     * match any single for end of the string
     *
     * @param string $string
     * @return string
     */
    public function wrapAnyAroundString($string)
    {
        return '*' . (string) $string . '*';
    }

    /**
     * any char match from the beginning of the string
     *
     * @param string $string
     * @return string
     */
    public function beingAnyMatchForString($string)
    {
        return '*' . (string) $string;
    }

    /**
     * any char match from the end of the string
     *
     * @param string $string
     * @return string
     */
    public function endAnyMatchForString($string)
    {
        return (string) $string . '*';
    }
}
