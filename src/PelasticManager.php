<?php namespace Quince\Pelastic;

use Elasticsearch\Client;
use Quince\Pelastic\Contracts\Api\Request\RequestInterface;
use Quince\Pelastic\Contracts\Api\Response\ResponseInterface;
use Quince\Pelastic\Contracts\PelasticManagerInterface;

class PelasticManager implements PelasticManagerInterface {

	/**
	 * @var Client
	 */
	protected $client;

	/**
	 * @param Client $client
	 */
	public function __construct(Client $client) {
		$this->setElastisearchClient($client);
	}

	/**
	 * Execute an enpoint request
	 *
	 * @param RequestInterface $request
	 * @return ResponseInterface
	 */
	public function executeRequest(RequestInterface $request) {
		return $request->executeByElasticClient($this->getElasticsearchClient());
	}

	/**
	 * Set elasticsearch client on the manager
	 *
	 * @param Client $client
	 * @return $this
	 */
	public function setElasticsearchClient(Client $client) {
		$this->client = $client;return $this;
	}

	/**
	 * Get elasticsearch client
	 *
	 * @return Client
	 */
	public function getElasticsearchClient() {
		return $this->client;
	}
}