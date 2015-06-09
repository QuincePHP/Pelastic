<?php namespace Quince\Pelastic\Connection;

use GuzzleHttp\Client;
use GuzzleHttp\Message\Request;
use Quince\Pelastic\Contracts\Connection\HttpConnectionInterface;
use Quince\Pelastic\PelasticManager;

class GuzzleConnection implements HttpConnectionInterface {

    /**
     * @var PelasticManager
     */
    protected $manager;

    /**
     * @var string
     */
    protected $host;

    /**
     * @var array
     */
    protected $response;

    /**
     * @param $host
     * @param PelasticManager $manager
     */
    public function __construct($host, PelasticManager $manager = null)
    {
        $this->manager = $manager;

        $this->client = new Client(['base_url' => $host]);

        $this->host = $host;

        if (null === $manager) {
            $this->manager = PelasticManager::getInstance();
        }
    }

    /**
     * Perform an http request
     *
     * @param $method
     * @param $uri
     * @param array $params
     * @param array $body
     * @param array $options
     * @return mixed
     */
    public function performRequest($method, $uri, array $params = null, array $body = null, array $options = null)
    {
        $options = (array) $options;

        if (!empty($body)) {
            $options['body'] = json_encode($body);
        }

        $request = $this->client->createRequest($method, $uri, (array) $options);

        if (!empty($params)) {
            $query = $request->getQuery();
            foreach ($params as $key => $value) {
                $query->set($key, $value);
            }
        }

        return $this->response = $this->sendThenCheck($request);
    }

    /**
     * Send the request and get result
     *
     *
     * @TODO Check for exception
     * @param Request $request
     * @return mixed
     */
    protected function sendThenCheck(Request $request)
    {
        return $response = $this->client->send($request)->json();
    }
}