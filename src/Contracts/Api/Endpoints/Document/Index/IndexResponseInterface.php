<?php namespace Quince\Pelastic\Contracts\Api\Endpoints\Document\Index;

use Quince\Pelastic\Contracts\Api\Response\ResponseInterface;

interface IndexResponseInterface extends ResponseInterface {

    /**
     * Proxy to get created index id
     *
     * @return string
     */
    public function id();

    /**
     * Did the document created?
     *
     * @return bool
     */
    public function created();

    /**
     * Get index
     *
     * @return string
     */
    public function getIndex();

    /**
     * Get type
     *
     * @return null|string
     */
    public function getType();

    /**
     * Get version
     *
     * @return int
     */
    public function getVersion();
}