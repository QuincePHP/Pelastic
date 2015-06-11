<?php namespace Quince\Pelastic\Contracts\Api\Response;

interface RawResponseInterface {

    /**
     * Set array
     *
     * @param array $data
     * @return void
     */
    public function setArray(array &$data);

    /**
     * Get response array
     *
     * @return array
     */
    public function getArray();
}