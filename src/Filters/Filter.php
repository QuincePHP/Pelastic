<?php namespace Quince\Pelastic\Filters;

use Quince\Pelastic\AccessibleMutatableTrait;
use Quince\Pelastic\Contracts\Filters\FilterInterface;

abstract class Filter implements FilterInterface {

    use AccessibleMutatableTrait;

    /**
     * Put a filter interface instance into array fields
     *
     * @param string          $field
     * @param FilterInterface $filter
     * @return array
     */
    protected function putQueryIntoArrayField($field, FilterInterface $filter)
    {
        return $this->putIntoArrayField($field, $filter);
    }

}