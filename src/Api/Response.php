<?php namespace Quince\Pelastic\Api;

class Response {

    /**
     * @var mixed
     */
    protected $info;

    /**
     * @var integer
     */
    protected $statusCode;

    /**
     * @var array
     */
    protected $remoteResponse;

    /**
     * Set status code
     *
     * @param $statusCode
     * @return $this
     */
    public function setStatusCode($statusCode)
    {
        $this->statusCode = (int) $statusCode;
        return $this;
    }

    /**
     * Set elasticsearch remote response
     *
     * @param array $response
     * @return $this
     */
    public function setRemoteResponse(array $response)
    {
        $this->remoteResponse = $response;
        return $this;
    }

    /**
     * Curl info
     *
     * @param $info
     * @return $this
     */
    public function setInfo($info)
    {
        $this->info = $info;
        return $this;
    }

    /**
     * Get response status code
     *
     * @return int
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * Get remote response
     *
     * @return array
     */
    public function getRemoteResponse()
    {
        return $this->remoteResponse;
    }

    /**
     * Get info
     *
     * @return mixed
     */
    public function getInfo()
    {
        return $this->info;
    }
}