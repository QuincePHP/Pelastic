<?php namespace Quince\Pelastic\Api;


use Elasticsearch\Client;
use Quince\Pelastic\Contracts\Api\Request\Http;
use Quince\Pelastic\Contracts\Api\Request\RequestInterface;
use Quince\Pelastic\Contracts\Api\Request\ResponseInterface;
use Quince\Pelastic\Utils\AccessibleMutatableTrait;

abstract class Request implements RequestInterface {

    use AccessibleMutatableTrait;

    /**
     * Convert a request to http
     *
     * @return Http
     */
    abstract public function toHttp();

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