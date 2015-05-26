<?php namespace Quince\Pelastic\Queries;

use Quince\Plastic\Contracts\Queries\AccessorMutatorInterface;

abstract class Query implements AccessorMutatorInterface {

	/**
	 * @var array
	 */
	protected $optionAttribute = [];

	/**
	 * Gets the attribute from options array
	 *
	 * @param string $attributeName
	 * @param bool   $hardCheck
	 * @param null   $defaultValue
	 * @return null
	 * @throws PlasticLogicException
	 */
	public function getAttribute($attributeName, $hardCheck = false, $defaultValue = null)
	{
		$attributes = $this->getOptionAttribute();

		if (isset($attributes[$attributeName])) {

			return $attributes[$attributeName];

		} elseif ($hardCheck) {

			throw new PlasticLogicException("You should have set a value for {$attributeName}.");

		}

		return $defaultValue;
	}

	/**
	 * Set attribute on options array
	 *
	 * @param string $attributeName
	 * @param mixed $value
	 * @return self
	 */
	public function setAttribute($attributeName, $value)
	{
		$this->optionAttribute[$attributeName] = $value;

		return $this;
	}

	/**
	 * Getting option attribute
	 *
	 * @return array
	 */
	protected function getOptionAttribute()
	{
		return $this->optionAttribute;
	}
}
