<?php namespace Quince\Pelastic\Queries;

use Quince\Exceptions\PlasticLogicException;

abstract class Query {

    /**
     * @var array
     */
    protected $optionAttribute = [];

    /**
     * Gets the attribute from options array
     *
     * @param $attributeName
     * @param null $defaultValue
     * @param bool $hardCheck
     * @return null
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
    protected function setAttribute($attributeName, $value)
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