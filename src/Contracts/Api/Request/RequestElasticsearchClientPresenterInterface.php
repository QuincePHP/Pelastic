<?php namespace Quince\Pelastic\Contracts\Api\Request;

interface RequestElasticsearchClientPresenterInterface {

    /**
     * Convert request to an elasticsearch client representation
     *
     * @return array
     */
    public function toElasticClient();
}