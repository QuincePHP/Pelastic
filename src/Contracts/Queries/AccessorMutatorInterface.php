<?php namespace Quince\Plastic\Contracts\Queries;

interface AccessorMutatorInterface {

    /**
     * Get attribute
     *
     * @param $attributeName
     * @param bool $hardCheck
     * @param null $defaultValue
     * @return mixed
     */
    public function getAttribute($attributeName, $hardCheck = false, $defaultValue = null);

    /**
     * Set attribute
     *
     * @param $attributeName
     * @param $attributeValue
     * @return $this
     */
    public function setAttribute($attributeName, $attributeValue);

}