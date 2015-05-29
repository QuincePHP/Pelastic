<?php namespace Quince\Pelastic\Filters;

use Quince\Pelastic\Contracts\Filters\TermFilterInterface;

class TermFilter extends Filter implements TermFilterInterface {

    use FieldFilterableTrait;

}