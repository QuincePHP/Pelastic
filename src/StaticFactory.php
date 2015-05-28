<?php namespace Quince\Pelastic;

use Stringy\StaticStringy;

abstract class StaticFactory {

    /**
     * Make string studly
     *
     * @param $string
     * @return string
     */
    public static function makeStudly($string)
    {
        return ucfirst(StaticStringy::camelize($string));
    }

}