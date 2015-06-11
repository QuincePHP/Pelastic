<?php namespace Quince\Pelastic\Api\Request;

use Quince\Pelastic\Contracts\Api\Request\RequestInterface;
use Quince\Pelastic\Utils\AccessibleMutatableTrait;

abstract class Request implements RequestInterface {

    use AccessibleMutatableTrait;

    /**
     * Convert request to an elasticsearch client representation
     *
     * @return array
     */
    abstract public function toElasticClient();

    /**
     * @return mixed
     */
    abstract public function getResponseClassOfRequest();

}