<?php namespace Quince\Pelastic\Contracts;

use Elasticsearch\Client;

interface PelasticManagerInterface {

    /**
     * Set elasticsearch client on the manager
     *
     * @param Client $client
     * @return $this
     */
    public function setElastisearchClient(Client $client);

    /**
     * Get elasticsearch client
     *
     * @return Client
     */
    public function getElasticsearchClient();

}