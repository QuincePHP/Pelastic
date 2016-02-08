<?php namespace Quince\Pelastic\Api\Endpoints\Document\Get;

use Elasticsearch\Client;
use Quince\Pelastic\Api\Request\Request;
use Quince\Pelastic\Api\Response\RawResponse;
use Quince\Pelastic\Contracts\Api\Endpoints\Document\Get\GetRequestInterface;
use Quince\Pelastic\Contracts\Api\Endpoints\Document\Get\GetResponseInterface;
use Quince\Pelastic\Contracts\Api\Response\ResponseInterface;
use Quince\Pelastic\Contracts\DocumentInterface;
use Quince\Pelastic\Exceptions\PelasticException;
use Quince\Pelastic\Exceptions\PelasticInvalidArgumentException;

/**
 * Class GetRequest
 * @package Quince\Pelastic\Api\Endpoints\Document\Get
 */
class GetRequest extends Request implements GetRequestInterface
{

    /**
     * @var DocumentInterface
     */
    protected $document;

    /**
     * Convert request to an elasticsearch client representation
     *
     * @return array
     */
    public function toElasticClient()
    {
        return $this->getOptionAttribute();
    }

    /**
     * Get name of the response of this request
     *
     * @return string
     */
    public function getResponseClassOfRequest()
    {
        return GetResponse::class;
    }

    /**
     * Execute the request by elasticsearch client
     *
     * @param Client $client
     * @return ResponseInterface
     */
    public function executeByElasticClient(Client $client)
    {
        $params = $this->toElasticClient();

        $responseClass = $this->getResponseClassOfRequest();
        /** @var GetResponseInterface $response */
        $response = new $responseClass();

        $result = RawResponse::build($client->get($params));

        if (null !== $this->document) {
            $response->setDocument($this->document);
        }

        $response->build($result);

        return $response;
    }

    /**
     * Set id
     *
     * @param $id
     * @return $this
     */
    public function setId($id)
    {
        $this->setAttribute('id', (string)$id);

        return $this;
    }

    /**
     * A proxy to set id
     *
     * @param $id
     * @return $this
     */
    public function id($id)
    {
        return $this->setId($id);
    }

    /**
     * Get from document
     *
     * @param DocumentInterface $document
     * @return $this
     */
    public function fromDocument(DocumentInterface $document)
    {
        if (null === ($id = $document->getId())) {
            throw new PelasticInvalidArgumentException(
                "For accessing GET api your document should provide an ID."
            );
        }

        $this->document = $document;
    }

    /**
     * Get document id
     *
     * @return string
     */
    public function getDocumentId()
    {
        return $this->getAttribute('id', true);
    }

    /**
     * Get document id
     *
     * @return string
     */
    public function getId()
    {
        return $this->getDocumentId();
    }

    /**
     * Set version
     *
     * @param $version
     * @return $this
     */
    public function setVersion($version)
    {
        $this->setAttribute('version', (string)$version);
    }

    /**
     * Only perform a HEAD request to check that document exists
     * @return $this
     * @throws PelasticException
     */
    public function onlyCheck()
    {
        throw new PelasticException("This option is not supported now");
    }

    /**
     * Should the request be only checked with a HEAD request
     *
     * @return bool
     */
    public function shouldBeOnlyChecked()
    {
        return false;
    }

    /**
     * Only load source attributes
     *
     * @return $this
     * @throws PelasticException
     */
    public function onlySource()
    {
        throw new PelasticException("This options is not supported now");
    }

    /**
     * Should the request only load sources?
     *
     * @return bool
     */
    public function shouldOnlyLoadSource()
    {
        return false;
    }

    /**
     * Set fields params
     *
     * @param array $fields
     * @return $this
     */
    public function setFields(array $fields)
    {
        $this->setAttribute('fields', $fields);

        return $this;
    }

    /**
     * Set parent param
     *
     * @param $parent
     * @return $this
     */
    public function setParent($parent)
    {
        $this->setAttribute('parent', $parent);

        return $this;
    }

    /**
     * Set preference
     *
     * @param $pref
     * @return $this
     */
    public function setPreference($pref)
    {
        $this->setAttribute('preference', $pref);

        return $this;
    }

    /**
     * Include this source fields
     *
     * @param array $fields
     * @return $this
     */
    public function includeSource(array $fields)
    {
        $this->setAttribute('_source_include', $fields);

        return $this;
    }

    /**
     * Exclude this source fields
     *
     * @param array $fields
     * @return $this
     */
    public function excludeSource(array $fields)
    {
        $this->setAttribute('_source_exclude', $fields);

        return $this;
    }

    /**
     * Should be realtime
     *
     * @param bool $realtime
     * @return $this
     */
    public function realtime($realtime)
    {
        $this->setAttribute('realtime', (bool)$realtime);

        return $this;
    }

    /**
     * Set version type param
     *
     * @param $versionType
     * @return $this
     */
    public function setVersionType($versionType)
    {
        $this->setAttribute('version_type', $versionType);

        return $this;
    }

    /**
     * Should add source or not
     *
     * @param array $source
     * @return $this
     */
    public function setSource($source)
    {
        $this->setAttribute('_source', $source);

        return $this;
    }

    /**
     * Set routing params
     *
     * @param $routing
     * @return $this
     */
    public function setRouting($routing)
    {
        $this->setAttribute('routing', $routing);

        return $this;
    }

    /**
     * Set refresh param
     *
     * @param $refresh
     * @return $this
     */
    public function setRefresh($refresh)
    {
        $this->setAttribute('refresh', $refresh);

        return $this;
    }

    /**
     * Set index
     *
     * @param $index
     * @return $this
     */
    public function setIndex($index)
    {
        $this->setAttribute('index', $index);

        return $this;
    }

    /**
     * Get index
     *
     * @param $index
     * @return mixed
     */
    public function getIndex($index)
    {
        return $this->getAttribute('index', true);
    }

    /**
     * Set type
     *
     * @param $type
     * @return $this
     */
    public function setType($type)
    {
        $this->setAttribute('type', $type);

        return $this;
    }


    /**
     * @param int $from
     * @param int $size
     * @return $this
     */
    public function paginate($from = 0, $size = 10)
    {
        $this->setAttribute('from', $from);
        $this->setAttribute('size', $size);
        return $this;

    }

}