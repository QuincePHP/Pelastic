<?php namespace Quince\Pelastic\Api\Document;

use Quince\Pelastic\Api\Response;
use Quince\Pelastic\Contracts\Api\Document\Index\IndexResponseInterface;
use Quince\Pelastic\Contracts\Api\ResponseInterface;
use Quince\Pelastic\Contracts\RawResponseInterface;

class IndexResponse extends Response implements IndexResponseInterface {

    /**
     * @var array
     */
    protected $params;

    /**
     * Build from raw array
     *
     * @param RawResponseInterface $raw
     * @return ResponseInterface
     */
    public function build(RawResponseInterface $raw)
    {
        $this->raw = $raw;
    }

    /**
     * Get created index id
     *
     * @return string
     */
    public function getCreatedId()
    {
        return $this->raw['_id'];
    }

    /**
     * Proxy to get created index id
     *
     * @return string
     */
    public function id()
    {
        return $this->getCreatedId();
    }

    /**
     * Did the document created?
     *
     * @return bool
     */
    public function created()
    {
        return (bool) $this->raw['created'];
    }

    /**
     * Get index
     *
     * @return string
     */
    public function getIndex()
    {
        return $this->raw['_index'];
    }

    /**
     * Get type
     *
     * @return null|string
     */
    public function getType()
    {
        return isset($this->raw['_type']) ? $this->raw['_type'] : null;
    }

    /**
     * Get version
     *
     * @return int
     */
    public function getVersion()
    {
        return $this->raw['_version'];
    }
}