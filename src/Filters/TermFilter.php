<?php namespace Quince\Pelastic\Filters;

use Quince\Pelastic\Contracts\Filters\TermFilterInterface;

class TermFilter extends Filter implements TermFilterInterface {

    use FieldFilterableTrait;

    /**
     * An array representation of the object
     *
     * @return array
     */
    public function toArray()
    {
        $field = $this->getField(true);

        $value = $this->getValue(true);

        return [
            "term" => [
                $field => [
                    "value" => $value
                ]
            ]
        ];
    }

    /**
     * Field which the term filter should be applied on it
     * a term filter is faster than a term query because it does not care about
     * scoring algos.
     *
     * @param string $field
     * @return $this
     */
    public function fieldForTerm($field)
    {
        return $this->setField($field);
    }

    /**
     * A proxy for field to exact match
     *
     * @param string $field
     * @return $this
     */
    public function fieldToExactMatch($field)
    {
        return $this->setField($field);
    }

    /**
     * Value for the field to perform the exact match filter
     *
     * @param string $value
     * @return $this
     */
    public function valueToExactMatch($value)
    {
        return $this->setValue($value);
    }

    /**
     * A proxy for valueToExactMatch
     *
     * @param string $value
     * @return $this
     */
    public function valueForTerm($value)
    {
        return $this->setValue($value);
    }
}