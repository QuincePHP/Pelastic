<?php namespace Quince\Pelastic\Contracts\Queries;

interface WildcardQueryInterface extends QueryInterface, FieldQueryableInterface {

	/**
	 * Set field to apply wildcard query
	 *
	 * @param string $field
	 * @return $this
	 */
	public function setWildCardField($field);

	/**
	 * A proxy on setWildCardFieldMethod
	 *
	 * @param mixed $field
	 * @return $this
	 */
	public function setField($field);

	/**
	 * A proxy on set field method
	 *
	 * @param mixed $field
	 * @return $this
	 */
	public function forField($field);

	/**
	 * Set wild card value
	 *
	 * @param string $value
	 * @return $this
	 */
	public function setWildCardValue($value);

	/**
	 * A proxy on setWildCardValue
	 *
	 * @param string $value
	 * @return $this
	 */
	public function like($value);

	/**
	 * Create string for wildcard matching with "?"
	 *
	 * @param string $first
	 * @param string $second
	 * @return string
	 */
	public function createSingleAny($first = '', $second = '');

	/**
	 * Create string for wildcard matching with "*"
	 *
	 * @param string $first
	 * @param string $second
	 * @return string
	 */
	public function createMultiAny($first = '', $second = '');

	/**
	 * Match only with single character in both sides of an string
	 *
	 * @param string $string
	 * @return string
	 */
	public function wrapSingleAroundString($string);

	/**
	 * Only match single for end of the string
	 *
	 * @param string $string
	 * @return string
	 */
	public function endSingleMatchForString($string);

	/**
	 * Single char match from the beginning of the string
	 *
	 * @param string $string
	 * @return string
	 */
	public function beginSingleMatchForString($string);

	/**
	 * match any single for end of the string
	 *
	 * @param string $string
	 * @return string
	 */
	public function wrapAnyAroundString($string);

	/**
	 * any char match from the beginning of the string
	 *
	 * @param string $string
	 * @return string
	 */
	public function beingAnyMatchForString($string);

	/**
	 * any char match from the end of the string
	 *
	 * @param string $string
	 * @return string
	 */
	public function endAnyMatchForString($string);

}
