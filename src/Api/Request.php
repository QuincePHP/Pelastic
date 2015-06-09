<?php namespace Quince\Pelastic\Api;

use Quince\Pelastic\AccessibleMutatableTrait;
use Quince\Pelastic\Contracts\Api\Http;
use Quince\Pelastic\Contracts\Api\RequestHttpPresenterInterface;
use Quince\Pelastic\Contracts\Api\RequestInterface;
use Quince\Pelastic\PelasticManager;

abstract class Request implements  RequestInterface, RequestHttpPresenterInterface {

    /**
     * @var PelasticManager
     */
    protected $manager;

    /**
     * Bootstrap the class
     */
    public function __construct()
    {
        $this->bootstrap();
    }

    use AccessibleMutatableTrait;

    /**
     * Execute a request
     *
     * @return array
     */
    public function execute()
    {
        $httpPresentation = $this->toHttp();
    }

    /**
     * Bootstrap the object
     *
     * @return void
     */
    protected function bootstrap()
    {
        $this->manager = PelasticManager::getInstance();
    }

    /**
     * Convert a request to http
     *
     * @return Http
     */
    abstract public function toHttp();
}