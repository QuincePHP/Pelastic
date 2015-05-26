<?php namespace Quince\Pelastic\Queries;

use Quince\Plastic\Contracts\Queries\AccessorMutatorInterface;
use Quince\Plastic\Exceptions\PlasticLogicException;

abstract class Query implements AccessorMutatorInterface {

    /**
     * @var array
     */
    protected $optionAttribute = [];

    /**
     * Gets the attribute from options array
     *
     * @param $attributeName
     * @param bool $hardCheck
     * @param null $defaultValue
     * @return null|string
     * @throws PlasticLogicException
     */
    public function getAttribute($attributeName, $hardCheck = false, $defaultValue = null)
    {
        $attributes = $this->getOptionAttribute();

        if (isset($attributes[$attributeName])) {

            return $attributes[$attributeName];

        }elseif ($hardCheck) {

            throw new PlasticLogicException("You should have set a value for {$attributeName}.");

        }

        return $defaultValue;
    }

    /**
     * Set attribute on options array
     *
     * @param $attributeName
     * @param $value
     * @return $this
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

    /**
     * Sets boost value on query
     *
     * @param double $boostValue
     * @return $this
     */
    public function setBoost($boostValue)
    {
        $this->setAttribute('boost', (double) $boostValue);
        return $this;
    }

    /**
     * Get boost attribute
     *
     * @return null|string
     */
    public function getBoost()
    {
        return $this->getAttribute('boost', false, null);
    }
}