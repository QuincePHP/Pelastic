<?php namespace Quince\Pelastic\Contracts\Queries;

interface AccessorMutatorInterface {

	/**
	 * Get attribute
	 *
	 * @param string $attributeName
	 * @param bool   $hardCheck
	 * @param null   $defaultValue
	 * @return mixed
	 */
	public function getAttribute($attributeName, $hardCheck = false, $defaultValue = null);

	/**
	 * Set attribute
	 *
	 * @param string $attributeName
	 * @param mixed  $attributeValue
	 * @return self
	 */
	public function setAttribute($attributeName, $attributeValue);

}
