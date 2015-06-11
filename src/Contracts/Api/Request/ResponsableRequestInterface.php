<?php namespace Quince\Pelastic\Contracts\Api\Request;

use Elasticsearch\Client;
use Quince\Pelastic\Contracts\Api\Response\ResponseInterface;

interface ResponsableRequestInterface {

    /**
     * Get response class of the request
     *
     * @return ResponseInterface|string
     */
    public function getResponseClassOfRequest();

    /**
     * Execute the request by elasticsearch client
     *
     * @param Client $client
     * @return ResponseInterface
     */
    public function executeByElasticClient(Client $client);

}