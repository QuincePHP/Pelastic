<?php namespace Quince\Pelastic\Contracts\Api;

use Quince\Pelastic\AccessibleMutatableTrait;

class Http {

    use AccessibleMutatableTrait;

    /**
     * @param $method
     * @param $uri
     * @param array $params
     * @param array $body
     * @param array $options
     */
    public function __construct($method, $uri, array $params = null, array $body = null, array $options = null)
    {
        $this->setAttribute('method', $method);
        $this->setAttribute('uri', $uri);

        if (null !== $params) {
            $this->setAttribute('params', (array) $params);
        }

        if (null !== $body) {
            $this->setAttribute('body', $body);
        }

        if (null !== $options) {
            $this->setAttribute('options', $options);
        }
    }

    /**
     * Request has body
     *
     * @return bool
     */
    public function hasBody()
    {
        return isset($this['body']);
    }

    /**
     * Get body of the request
     *
     * @return array
     */
    public function getBody()
    {
        return $this->getAttribute('body', false, null);
    }

    /**
     * Get uri of the request
     *
     * @return string
     */
    public function getUri()
    {
        return $this->getAttribute('uri');
    }

    /**
     * Get http method of the request
     *
     * @return string
     */
    public function getHttpMethod()
    {
        return $this->getAttribute('method');
    }

    /**
     * Get params of the request
     *
     * @return array|null
     */
    public function getParams()
    {
        return $this->getAttribute('params', false, null);
    }

    /**
     * Get options of the request
     *
     * @return null|array
     */
    public function getOptions()
    {
        return $this->getAttribute('options', false, null);
    }
}