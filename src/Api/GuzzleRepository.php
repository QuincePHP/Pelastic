<?php namespace Quince\Pelastic\Api;

use GuzzleHttp\Client;
use Quince\Pelastic\Contracts\Api\RepositoryInterface;

abstract class GuzzleRepository implements RepositoryInterface {

    /**
     * Get guzzle client
     *
     * @return Client
     */
    public function getGuzzleClient()
    {
        return new Client();
    }

}