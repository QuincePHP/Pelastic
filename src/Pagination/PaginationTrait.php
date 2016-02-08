<?php

/**
 * Created by PhpStorm.
 * User: ra3oul
 * Date: 2/8/16
 * Time: 11:10 AM
 */
trait PaginationTrait
{
    /**
     * @var
     */
    protected $from;
    /**
     * @var
     */
    protected $size;


    /**
     * @param $size
     */
    public function setSize($size)
    {
        $this->size = $size;
    }

    /**
     * @param $from
     */
    public function setFrom ($from)
    {
        $this->from=$from;
    }

    /**
     * @return int
     */

    public function getFrom()
    {
        return isset($this->size) ? $this->size : 0;
    }

    /**
     * @return int
     */
    public function getSize()
    {
        return isset($this->size) ? $this->size : 10;
    }


}